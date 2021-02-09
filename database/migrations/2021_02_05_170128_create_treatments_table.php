<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->integer('Ficha')->nullable($value = true);
            $table->string('Nombre');
            $table->string('Apellidos');
            $table->string('Atencion');
            $table->string('Profesional')->nullable($value = true);
            $table->integer('TotalAtencion');
            $table->integer('TotalLaboratorios');
            $table->integer('TotalRealizado');
            $table->integer('TotalAbonado');
            $table->integer('Avance');
            $table->integer('Global');
            $table->date('Proxima_cita')->nullable($value = true);

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
        Schema::dropIfExists('treatments');
    }
}
