<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Controllers\Transaction\TransactionController;
use App\Transaction_log;
use App\OAuth_clients;
use App\User;
use GuzzleHttp\Subscriber\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;
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
        $message_code = 57;             // initialize with illegal transaction
        // log activity
        try {
            $payer = User::findOrFail($request->payer_id)->with(['primary_account', 'account_status'])
                ->first();  // get payer and primary a/c information
            $payee = OAuth_clients::with('user')->with('user.account_status')
                ->whereId($request->payee_id)->first();
            session()->flash('flash_message', 'Found Payee/Payer');
        } catch (Exception $e) {
            session()->flash('flash_message', 'Cannot find payee/payer');
            $message_code = 14;
        }

        $activity_id = Queue::push($this->logActivity($payer, $payee, $request->txn_currencyid, $request->amount_in_txn_currency), '', 'activity_log');


        // authenticate Payee account
        if ($request->amount_in_txn_currency > 0) {
            // Check fraud
            $fraud = Queue::push($controller->checkFraud($payer));
            if ($this->checkPayeeAccount($payee->user)) {

                // authenticate and transact for payer
                if (Hash::check($request->password, $payer->password)) {
                    // check payee
                    $message_code = $this->checkPayerAccount($payer, $request);
                    if ($message_code = 0) {
                        session()->flash('flash_message', 'Transaction approved');
                    }
                } else {
                    session()->flash('flash_message', 'Payer Kudotsu account/PIN wrong.');
                    $message_code = 28;
                }
            } else {
                session()->flash('flash_message', 'Payee Kudotsu account not approved');
                $message_code = 20;
            }
            Queue::push($controller->store($message_code, $payer, $payee), '', 'activity_log');
        }
        else {
            session()->flash('flash_message', $payee.$request->payer_id.$payer);//'Invalid Amount or trying to pay yourself');
            $message_code = 13;
        }
            return view('transaction.response');
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
            $activity = Activity_log::create([
                'id' => (string)Uuid::generate(4),
                'payer_id' => $payer->id,
                'payee_id' => $payee->user->id,
                'txn_currencyid' => 2,
                'amount_in_txn_currency' => $amount_in_txn_currency,
                'number_of_kudos' => Currency::findOrFail($txn_currency_id)->Kudos_exchange * $amount_in_txn_currency
            ]);
            session()->flash('flash_message', 'Activity logged');
            return $activity->id;
        }
        catch (Exception $e)
        {
            session()->flash('flash_message', 'Error in activity logging');
            return FALSE;
        }
    }

    public function checkPayeeAccount(User $payee)
    {
        // check validity of user account
        if (!$payee->account_status->status ='active')
        {
            session()->flash('flash_message', 'Payee account not active', 'ISO8583 code 76');
            return FALSE;
        }
        else return TRUE;
    }

    public function checkPayerAccount($payer, $request)
    {
        // check validity of payer account
        // check transaction log for the day
        // check sufficient kudos
        // debit from paypal if required
        // send notification to payer and payee

        if ($payer->account_status->status ='active') {
            // Calculate number of kudos
            $noOfKudos = Currency::findOrFail($request->txn_currencyid)->Kudos_exchange * $request->amount_in_txn_currency;

            // Check transaction_limit
            if ($payer->transaction_limit_kudos >= $noOfKudos) {
                session()->flash('flash_message', 'Within transaction limit.');

                // Check daily_limit
                if ($payer->kudos_used_today + $noOfKudos <= $payer->daily_limit_kudos) {
                    session()->flash('flash_message', 'Within daily limit');

                    // Check if need to go to payment gateway
                    if ($payer->kudos_available_balance < $noOfKudos)
                    {
                        if ($this->PaypalApproved()){
                            session()->flash('flash_message', 'Approved by Payment Gateway');
                            return 0;
                        }
                        else {
                            session()->flash('flash_message', 'Unapproved by Payment Gateway, try another card');
                            return 85;
                        }
                    }
                    else {
                        session()->flash('flash_message', 'Transaction approved using existing kudos.');
                        return 0;
                    }
                } else {
                    session()->flash('flash_message', 'Exceeded daily limit');
                    return 51;
                }
            } else {
                session()->flash('flash_message', 'Exceeded transaction limit.');
                return 51;
            }
        }
        else {
            session()->flash('flash_message', 'Payer account not active');
        }
        session()->flash('flash_message', 'Payer account not approved - unknown error');
        return 14;
    }

    public function PaypalApproved()
    {
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
}