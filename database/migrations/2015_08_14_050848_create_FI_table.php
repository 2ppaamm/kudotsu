<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFITable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FIs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('bank_name');
            $table->string('bank_identifier_code');
            $table->integer('home_currency')->unsigned();
            $table->foreign('home_currency')->references('id')->on('currencies');
            $table->integer('ledger_balance');
            $table->integer('onhold');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('FIs');
    }
}
