<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('Sucursal');
            $table->string('Nombre');
            $table->string('Apellido');
            $table->integer('Categoria_Nr');
            $table->string('Categoria_Nombre');
            $table->integer('Tratamiento_Nr');
            $table->string('Profesional');
            $table->string('Estado')->nullable($value = true);
            $table->string('Convenio');
            $table->integer('Prestacion_Nr');
            $table->string('Prestacion_Nombre');
            $table->string('Pieza_Tratada')->nullable($value = true);
            $table->dateTime('Fecha_Realizacion');
            $table->integer('Precio_Prestacion');
            $table->integer('Abonoo');
            $table->integer('Total');
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
        Schema::dropIfExists('actions');
    }
}
