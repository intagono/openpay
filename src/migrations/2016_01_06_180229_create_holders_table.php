<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holders', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('openpay_id');

            $table->string('name');
            $table->string('last_name')->nullable();

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            $table->string('street')->nullable();
            $table->string('colony')->nullable();
            $table->string('zipcode',5)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
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
        Schema::drop('holders');
    }
}
