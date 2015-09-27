<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Mockery\CountValidator\Exception;
use Webpatser\Uuid\Uuid;
use App\Activity_log;

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
    public function store(CreateTransactionRequest $request)
    {
        $payer = User::with('primary_account')->first();    // get payer and primary a/c information
        $payee = User::with('oauth_clients')
            ->where('id',"=", $request->client_id)->get();

        Queue::push($this->logActivity($payer,$payee,$request->amount_in_txn_currency),'','activity_log');

        // Authenticate payer with password
        if (Hash::check($request->password, $payer->password)) //if (Auth::once(['email'=>$request->username,'password'=>$request->password]))
        {
            \Illuminate\Support\Facades\Queue::push('SendData', '', 'nfc');
            //    create activity log and cache
            //    return 'Send to paypal';
        }
        else
        {
            return response()->json(['message' => 'Wrong User or PIN', 'ISO8583 code' => 55], 404);
        }


        if ($request->amount_in_txn_currency > $payer->primary_account->transaction_limit)
        {
            //  create token and one-time PIN
            //  send to customer for verification
            $this->issueActivityID($request);
        }

//        return Authorizer::issueAccessToken()['access_token'];
        return $payee;//amount_in_txn_currency; //debit transaction received
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

    public function logActivity(User $payer, $payee, $amount_in_txn_currency)
    {
        try {
        $activity_id = (string)Uuid::generate(4);
        $activity = Activity_log::create([
            'id' => $activity_id,
            'payer_id' => $payer->id,
            'payee_id' => $payee->first()->id,
            'txn_currencyid' => 2,
            'amount_in_txn_currency' => $amount_in_txn_currency
        ]);
        Cache::add($activity_id, $activity, 15);
        return TRUE;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => 'Error Logging', 'code' => 500], 500);
        }
    }
}

