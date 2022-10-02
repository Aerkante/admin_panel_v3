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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('image_id')->unsigned()->nullable();
            $table->date('birthday')->nullable();
            $table->string('telephone')->nullable();
            $table->string('phone')->nullable();
            $table->string('rg')->nullable();
            $table->string('cpf')->nullable();
            $table->enum('gender', ['m', 'f', 'x'])->default('m');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data');
    }
};
