<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->unsigned();
            $table->string('zip')->nullable();
            $table->string('street')->nullable();
            $table->string('complement')->nullable();
            $table->string('number')->nullable();
            $table->string('reference')->nullable();
            $table->string('neighborhood')->nullable();
            $table->integer('addressable_id')->unsigned()->index('addressable_id');
            $table->string('addressable_type', 100)->index('addressable_type');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
