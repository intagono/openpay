<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('openpay_id');

            $table->string('type');
            $table->string('brand')->nullable();

            $table->string('holder_name');
            $table->string('card_number');
            $table->string('expiration_month',2);
            $table->string('expiration_year',2);
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            $table->string('street')->nullable();
            $table->string('colony')->nullable();
            $table->string('zipcode',5)->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('country_code',2)->default("MX");

            $table->boolean('status')->default(true);

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
        Schema::drop('cards');
    }
}
