<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            /*
             * Agregamos en esta tabla los “foreign constraint” para roles y usuarios
             */
        });
        /*
        Schema::table('role_user', function($table){
            $table->foreign('id_user')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
        Schema::table('role_user', function($table){
            $table->foreign('role_id')
                    ->references('id')
                    ->on('roles');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
