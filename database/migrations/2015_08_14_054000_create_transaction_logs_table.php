<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('transaction_code');
            $table->string('transaction_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bank_account_id')->unsigned();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->string('merchant_code');
            $table->integer('txn_currencyid')->unsigned();
            $table->foreign('txn_currencyid')->references('id')->on('currencies');
            $table->decimal('amount_in_txn_currency',8,2);
            $table->integer('acc_currencyid')->unsigned();
            $table->foreign('acc_currencyid')->references('id')->on('currencies');
            $table->decimal('amount_in_acc_currency', 8, 2);
            $table->integer('amount_in_kudos');
            $table->string('transaction_address');
            $table->string('billing_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction_logs');
    }
}
