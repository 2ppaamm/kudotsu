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
            $table->bigIncrements('id');
            $table->string('activity_log_id');
            $table->foreign('activity_log_id')->references('id')->on('activity_logs');
            $table->string('transaction_code');
            $table->string('message_code');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bank_account_id')->unsigned();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->integer('acc_currencyid')->unsigned();
            $table->foreign('acc_currencyid')->references('id')->on('currencies');
            $table->decimal('amount_in_acc_currency', 8, 2);
            $table->string('transaction_address');
            $table->string('billing_address');
            $table->timestamps();
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
