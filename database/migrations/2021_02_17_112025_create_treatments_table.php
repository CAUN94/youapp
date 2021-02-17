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
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->unsigned()->nullable()
                ->references('id')->on('patients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->unsigned()->nullable()
                ->references('id')->on('status')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->unsigned()->nullable()
                ->references('id')->on('sucursals')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('benefit_treatment_id');
            $table->foreign('benefit_treatment_id')->unsigned()->nullable()
                ->references('id')->on('benefits_treatments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('professional_category_id');
            $table->foreign('professional_category_id')->unsigned()->nullable()
                ->references('id')->on('professional_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
