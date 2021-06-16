<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tarjeta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tablero_user');
            $table->unsignedBigInteger('id_tarjeta');
            $table->timestamps();
            
            $table->foreign('id_tablero_user')
                    ->references('id')
                    ->on('user_tablero')
                    ->onDelete('cascade');
            $table->foreign('id_tarjeta')
                    ->references('id')
                    ->on('tarjetas')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tarjeta');
    }
}
