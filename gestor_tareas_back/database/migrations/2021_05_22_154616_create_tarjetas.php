<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarjetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->string('id_Columna')->default("1")->nullable();
            $table->string('id_Tablero')->nullable();
            $table->integer('posicion')->default("0");
            $table->string('nombre');
            $table->boolean('check_fin')->nullable();
            $table->boolean('not_fecha_inicio')->default(false);
            $table->string('Fecha_inicio')->nullable();
            $table->string('Time_inicio')->nullable();
            $table->boolean('not_fecha_fin')->default(false);
            $table->string('Fecha_fin')->nullable();
            $table->string('Time_fin')->nullable();
            $table->string('tipo')->nullable();
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('tarjetas');
    }
}
