<?php
namespace App\Http\Controllers\Transaction;

use App\Activity_log;
use App\OAuth_clients;
use App\Transaction_log;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Jobs\SendReminderEmail;
use Illuminate\Support\Facades\Hash;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
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
    public function store(CreateTransactionRequest $request)
    {
        $payer = User::findOrFail($request->user_id);
        $payee = User::with('oauth_clients')
            ->where('id',"=", $request->client_id)->get();

        $activity_id = (string)Uuid::generate(4);
        $activity = Activity_log::create([
            'id' => $activity_id,
            'payer_id' => $payer->id,
            'payee_id' => $payee->first()->id,
            'txn_currencyid' => 2,
            'amount_in_txn_currency' => $request->amount_in_txn_currency
        ]);

        if (Hash::check($request->password, $payer->password))
        {
            \Illuminate\Support\Facades\Queue::push('SendData', '', 'nfc');
            return 'Sending message';
        }
//        return Authorizer::issueAccessToken()['access_token'];
        return $payee;//amount_in_txn_currency; //debit transaction received
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $transaction = Transaction_log::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'This transaction does not exist', 'code' => 404], 404);
        }
        return response()->json(['data' => $transaction], 200);
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
}