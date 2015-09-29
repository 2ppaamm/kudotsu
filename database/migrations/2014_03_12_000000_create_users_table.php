<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('is_admin');
            $table->rememberToken();
            $table->integer('account_status_id')->unsigned();
            $table->foreign('account_status_id')->references('id')->on('account_statuses');
            $table->integer('kudos_beginning_day_balance');
            $table->integer('kudos_ledger_balance');
            $table->integer('kudos_onhold_amt');
            $table->integer('kudos_available_balance');
            $table->integer('kudos_used_today');
            $table->integer('number_of_txn_day');
            $table->integer('net_day_txn_kudos');
            $table->time('kudos_last_update');
            $table->decimal('daily_limit_kudos',8,2);
            $table->decimal('transaction_limit_kudos', 8, 2);
            $table->integer('account_currency_id')->unsigned();
            $table->foreign('account_currency_id')->references('id')->on('currencies');
            $table->string('address');
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
        Schema::drop('users');
    }
}
