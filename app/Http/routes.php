<?php
Queue::getIron()->ssl_verifypeer = false;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controllers([
   'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
//Route::group(['prefix'=>'api/v1.1'],function() {
    Route::resource('accounts', 'AccountController', ['except' => ['create', 'edit']]);
    Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['create', 'show', 'index', 'store']]);
    Route::resource('accounts.transactions', 'AccountTransactionController', ['except' => ['edit', 'create', 'update', 'edit']]);
//});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('queue',function(){
    Queue::push('SendData');
    return "ok!";
});
Route::post('queue/demo',function(){
   return Queue::marshal();
});
Route::get('mail', function(){
//    dd(\Illuminate\Support\Facades\Config::get('mail'));
    $data =[];
    Mail::send('emails.welcome', $data, function($message){
        $message -> to('pamelaliusm@gmail.com')
            ->subject('From mail, your one-time PIN is '.time() . '. It will expire in 5 minutes.');
    });
    return 'ok,ok!';
});

class SendData{
    public function fire($job, $data){
        $data =[];
        \Illuminate\Support\Facades\Mail::send('emails.welcome', $data, function($message){
            $message -> to('pamelaliusm@gmail.com')
                ->subject('From queue testing laravel mail');
        });

//        File::append(app_path().'/hellos.txt',$data['string'], PHP_EOL);
//        $job -> delete();
    }
}



Route::get('payment', function(){
    return view('transaction.token');
});