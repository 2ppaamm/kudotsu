<?php

namespace App\Http\Controllers;

use App\Bank_account;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Transaction_log;
class AccountController extends Controller
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
    public function index()
    {
        return "I am in AccountController";
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
    public function store(CreateAccountRequest $request)
    {
        $values = $request ->only(['fi_id', 'user_id', 'account_number', 'account_type_id']);
        Bank_account::create($values);
        return response()->json(['message'=>'Account correctly added'],201);
 //       return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CreateAccountRequest $request, $id)
    {
        $account = Bank_account::find($id);
        if(!$account) {
            return response()->json(['message'=>'This account does not exist','code'=>404],404);
        }
            $fi_id = $request->get('fi_id');
            $account_number = $request->get('account_number');
            $account_type_id = $request->get('account_type_id');
            $account_currency = $request->get('currency_id');
            $account->fi_id = $fi_id;
            $account->account_number = $account_number;
            $account->account_type_id = $account_type_id;
            $account->currency_id = $account_currency;
            //return $account;
            $account->save();
            return response()->json(['message'=>'The account has been updated'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $account = Bank_account::find($id);
        if(!$account) {
            return response()->json(['message'=>'This account does not exist','code'=>404],404);
        }
        $transactions = $account->activities;
//        return $account;
        if (sizeof($transactions) > 0){
            return response()->json(['message'=>'You have done transactions on this account, and therefore cannot delete it', 'code'=>409], 409);
        }
        $account->delete();
        return response()->json(['message'=>'This account has been deleted.','code'=>409], 409);
    }
}