<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Controllers\Transaction\TransactionController;
use App\Transaction_log;
use App\OAuth_clients;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Mockery\CountValidator\Exception;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Webpatser\Uuid\Uuid;
use App\Activity_log;
use PayPal\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request, TransactionController $controller)
    {
        // find payee and payer
        $payer = User::with(['primary_account', 'account_status'])->first();    // get payer and primary a/c information
        $payee = OAuth_clients::with('user')->with('user.account_status')
            ->whereId($request->client_id)->first();

        // Log activity
        Queue::push($this->logActivity($payer,$payee,$request->txn_currencyid,$request->amount_in_txn_currency),'','activity_log');

        // Authenticate payer with password
        if (Hash::check($request->password, $payer->password))
        {
            // check payee account valid and payer account valid and funded
            if ($this->checkPayeeAccount($payee->user) and $this->checkPayerAccount($payer, $request))
            {
                return 'Transaction of $'.$request->amount_in_txn_currency.' to '.
                $payee->user->name.' is approved.';
            }
            else
            {
                return "Transaction is rejected";
            }// Queue up checking payer, payee and paypal
        }
        else
        {
            return response()->json(['message' => 'Wrong User or PIN', 'ISO8583 code' => 55], 404);
        }

        if ($request->amount_in_txn_currency > $payer->primary_account->transaction_limit)
        {
            //  create token and one-time PIN
            //  serve a view with access_token and OTP for verification
            //  new view to be served by transaction log
        }

//        return Authorizer::issueAccessToken()['access_token'];
        Queue::push($controller->store($payment, $request),'', 'transaction_log');
        return 'Your request to debit $'.$request->amount_in_txn_currency.' is being processed';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logActivity(User $payer, $payee, $txn_currency_id, $amount_in_txn_currency)
    {
        try {
            $noOfKudos = Currency::findOrFail($txn_currency_id)->Kudos_exchange * $amount_in_txn_currency;
            $activity_id = (string)Uuid::generate(4);
            $activity = Activity_log::create([
                'id' => $activity_id,
                'payer_id' => $payer->id,
                'payee_id' => $payee->user->id,
                'txn_currencyid' => 2,
                'amount_in_txn_currency' => $amount_in_txn_currency,
                'number_of_kudos' => $noOfKudos
            ]);
            Cache::add($activity_id, $activity, 15);
            return TRUE;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => 'Error Logging', 'code' => 500], 500);
        }
    }

    public function checkPayeeAccount(User $payee)
    {
        // check validity of user account
        if ($payee->account_status->status ='active')
        {
            return TRUE;
        }
        else
        {
            return response()->json(['message' => 'Account not active', 'ISO8583 code' => 76], 500);
//            return FALSE;
        }
    }

    public function checkPayerAccount($payer, $request, TransactionController $controller)
    {
        // check validity of account
        // check sufficient kudos
        // debit from paypal if required
        // send notification to payer and payee
        // check validity of user account

        if ($payer->account_status->status ='active')
        {
            $noOfKudos = Currency::findOrFail($request->txn_currencyid)->Kudos_exchange * $request->amount_in_txn_currency;

            if ($payer->kudos_available_balance < $noOfKudos)
            {
                // not enough kudos, need to go and get more
                $apiContext = new ApiContext(new OAuthTokenCredential(
                    'AUUtaT83w_ErtfGTsoCHdjgKK8tnI_WH2mFLwnD1nJ_ZyfuQ-EBbCFF-mLBtsK1yWyCMJzaSWLcVlgMP',
                    'ENvu8lo-d2QUxLsgUNp2VKxwEI2YvtivnAURwvEOO6ZpRTac65pABzkxH0N8JNbW6drCZSgN9qPbS-vZ'
                ));

                $payment = new Payment(
                    '{
                        "intent": "sale",
                        "payer": {
                        "payment_method": "credit_card",
                            "payer_info": {
                            "email": "'.$payer->email.'"
                            },
                            "funding_instruments": [
                                {
                                    "credit_card": {
                                    "number": "376217851682019",
                                        "type": "amex",
                                        "expire_month": 11,
                                        "expire_year": 2018,
                                        "cvv2": 874,
                                        "first_name": "'.$payer->name.'",
                                        "last_name": "Shopper"
                                    }
                                }
                            ]
                        },
                        "transactions": [
                            {
                                "amount": {
                                "total": "'.$request->amount_in_txn_currency.'",
                                    "currency": "USD"
                                },
                                "description": "This is the payment transaction description."
                            }
                        ]
                    }'
                );
                $payment->create($apiContext);
                if ($payment->state='approved') return TRUE;
                else return FALSE;
            }
            else
            {
                // enough kudos from account - no need to go to payment gateway
                return TRUE;
            }
        }
        else
        {
            return response()->json(['message' => 'Account not active', 'ISO8583 code' => 76], 500);
//            return FALSE;
        }
    }

    public function logTransaction($activity_id)
    {
        // call TransactionController to log transaction
        return True;
    }
}