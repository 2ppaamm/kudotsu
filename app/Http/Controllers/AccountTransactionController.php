<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transaction_log;
use App\Bank_account;

class AccountTransactionController extends Controller
{
    /** For authentication of user */
    public function __construct() {
        $this->middleware('auth.basic');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $account = Bank_account::find($id);
        if(!$account) {
            return response()->json(['message'=>'This account does not exist','code'=>404],404);
        }
        return response()->json(['data'=>$account->activities],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateTransactionRequest $request, $accountId)
    {
        $account = Bank_account::find($accountId);
        if(!$account) {
            return response()->json(['message'=>'This account does not exist','code'=>404],404);
        }

        $values = $request -> all();
        $values['acc_currencyid']= $account['currency_id'];
        // return $values;
        $account->activities()->create($values);
        return response()->json(['message'=>'The transaction was accepted'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $transaction_id)
    {
        $account = Bank_account::find($id);
        if(!$account) {
            return response()->json(['message'=>'This account does not exist','code'=>404],404);
        }
        $transaction_id =$account->activities->find($transaction_id);
        if (!$transaction_id) {
            return response()->json(['message'=> 'This transaction does not exist for this account', 'code'=>404], 404);
        }
        return response()->json(['data'=>$transaction_id],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
