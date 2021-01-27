<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('Estado');
            $table->dateTime('Fecha');
            $table->time('Hora_inicio');
            $table->time('Hora_termino');
            $table->datetime('Fecha_Generación');
            $table->integer('Tratamiento_Nr');
            $table->string('Profesional');
            $table->string('Rut_Paciente');
            $table->string('Nombre_paciente');
            $table->string('Apellidos_paciente');
            $table->string('Mail');
            $table->string('Telefono')->nullable($value = true);
            $table->string('Celular');
            $table->string('Convenio')->nullable($value = true);
            $table->string('Convenio_Secundario')->nullable($value = true);
            $table->dateTime('Generación_Presupuesto');
            $table->string('Sucursal');
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
        Schema::dropIfExists('appointments');
    }
}
