<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer("Atencion");
            $table->string("Profesional")->nullable($value = true);
            $table->string("Especialidad");
            $table->integer("Pago_Nr");
            $table->date("Fecha");
            $table->string("Rut");
            $table->string("Nombre");
            $table->string("Apellidos");
            $table->string("Tipo_Paciente")->nullable($value = true);
            $table->string("Convenio")->nullable($value = true);
            $table->string("Convenio_Secundario")->nullable($value = true);
            $table->integer("Boleta_Nr")->nullable($value = true);
            $table->integer("Total");
            $table->integer("Asociado");
            $table->string("Medio");
            $table->string("Banco")->nullable($value = true);
            $table->string("RutBanco")->nullable($value = true);
            $table->string("Cheque")->nullable($value = true);
            $table->dateTime("Vencimiento");
            $table->dateTime("Generado");
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
        Schema::dropIfExists('payments');
    }
}
