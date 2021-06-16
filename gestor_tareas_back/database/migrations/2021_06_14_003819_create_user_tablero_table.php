<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTableroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tablero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_tablero');
            $table->integer('aceptado')->default("0");
            $table->timestamps();
            
            $table->foreign('id_user')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('id_tablero')
                    ->references('id')
                    ->on('tableros')
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
        Schema::dropIfExists('user_tablero');
    }
}
