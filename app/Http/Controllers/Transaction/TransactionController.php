<?php
namespace App\Http\Controllers\Transaction;

use App\Activity_log;
use App\OAuth_clients;
use App\Transaction_log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Jobs\SendReminderEmail;
use Illuminate\Support\Facades\Hash;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Mockery\CountValidator\Exception;
use PayPal\Api\Payment;
use Webpatser\Uuid\Uuid;

class TransactionController extends Controller
{
    /** For authentication of user */
    public function __construct()
    {
//        $this->middleware('oauth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /** Add cache */
        $transactions = Cache::remember('transaction_logs', 15 / 60, function () {
            return Transaction_log::with('user')->with('bank_account')->with('currency')->get();//simplePaginate(10);
        });
        //       $transactions = Transaction_log::with('user')->with('bank_account')->with('currency')->get();
        return response()->json(['data' => $transactions], 200);
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
     * Store a newly created activity in storage,
     * then put the request on queue to authorization
     *
     * @param  Request $request
     * @return Response
     */
    public function store($message,$payer, $payee)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {

        $transaction = Transaction_log::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'This transaction does not exist', 'code' => 404], 404);
        }
        return response()->json(['data' => $transaction], 200);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => 'Error in finding transaction', 'code' => 404], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkFraud($payer){
        // number of transactions
        // kudos transacted vs available
        // location (future)
        session()->flash('flash_message', 'No fraud suspected.');
        return FALSE;
    }
}