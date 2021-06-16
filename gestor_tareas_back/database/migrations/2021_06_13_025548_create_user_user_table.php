<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_user', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user_a');
            $table->unsignedBigInteger('id_user_b');
            $table->integer('aceptado')->default("0");
            $table->timestamps();
            
            $table->foreign('id_user_a')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->foreign('id_user_b')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('user_user');
    }
}
