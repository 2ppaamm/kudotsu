<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('ISO_symbol', 3);
            $table->decimal('Kudos_exchange', 20,2);
            $table->string('country_organization',50);
            $table->string('type');
            $table->string('description', 100);
            $table->decimal('daily_limit', 8,2);
            $table->decimal('transaction_limit', 8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('currencies');
    }
}
