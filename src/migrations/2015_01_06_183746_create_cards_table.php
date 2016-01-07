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
            $table->string('customer_id');

            $table->string('type');
            $table->string('brand')->nullable();

            $table->string('holder_name');
            $table->string('card_number');
            $table->string('expiration_month',2);
            $table->string('expiration_year',2);
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();

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
