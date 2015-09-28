<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function(Blueprint $table)
        {
            $table->string('id',36)->primary();
            $table->integer('payer_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('users');
            $table->integer('payee_id')->unsigned();
            $table->foreign('payee_id')->references('id')->on('users');
            $table->integer('txn_currencyid')->unsigned();
            $table->foreign('txn_currencyid')->references('id')->on('currencies');
            $table->decimal('amount_in_txn_currency',8,2);
            $table->decimal('number_of_kudos', 20,2);
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
        Schema::drop('activity_logs');
    }
}