<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction_log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Jobs\SendReminderEmail;
class TransactionController extends Controller
{
    /** For authentication of user */
    public function __construct() {
        $this->middleware('oauth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /** Add cache */
        $transactions = Cache::remember('transaction_logs', 15/60, function() {
        return Transaction_log::with('user')->with('bank_account')->with('currency')->get();//simplePaginate(10);
    });
 //       $transactions = Transaction_log::with('user')->with('bank_account')->with('currency')->get();
        return response()->json(['data'=>$transactions],200);
//        return view('transaction.index')->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $user = User::findOrFail($request->user_id);
//        $this->dispatch(new SendReminderEmail($user));
        Queue::push('FileTimeWriter',['time'=>time()]);

        return $user;//amount_in_txn_currency; //debit transaction received
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $transaction = Transaction_log::find($id);
        if(!$transaction) {
            return response()->json(['message'=>'This transaction does not exist','code'=>404],404);
         }
        return response()->json(['data'=>$transaction],200);
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
    public function update(Request $request, $id)
    {
        //
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
