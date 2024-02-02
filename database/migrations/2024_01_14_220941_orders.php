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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('orderDate');
            $table->decimal('total',10,2);
            $table->unsignedBigInteger('state_id');
            $table->String('No_transaccion')->nullable();
            $table->String('paqueteria')->nullable();
            $table->String('numero_guia')->nullable();

            
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('restrict');
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
        //
    }
};
