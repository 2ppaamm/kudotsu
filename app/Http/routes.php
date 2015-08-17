<?php

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
Route::group(['prefix'=>'api/v1.1'],function() {
    Route::resource('accounts', 'AccountController', ['except' => ['create', 'edit']]);
    Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['create', 'show', 'index', 'store']]);
    Route::resource('accounts.transactions', 'AccountTransactionController', ['except' => ['edit', 'create', 'update', 'edit']]);
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});