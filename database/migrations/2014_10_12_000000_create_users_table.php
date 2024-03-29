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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
           // $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            //F
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('state_id');
            $table->rememberToken();
            $table->timestamps();

            //R
            $table->foreign('rol_id')->references('id')->on('rols')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
