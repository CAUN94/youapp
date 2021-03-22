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
            $table->integer('number');
            $table->dateTime('date');
            $table->time('hour')->nullable();
            $table->integer('benefit')->nullable();
            $table->integer('payment')->nullable();
            $table->string('bank')->nullable();
            $table->string('method')->nullable();
            $table->string('boucher_nr')->nullable();
            $table->string('reference')->nullable();
            $table->integer('minutes')->default(60)->nullable();
            $table->longText('health_record')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->unsigned()->nullable()
                ->references('id')->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('professional_id')->nullable();
            $table->foreign('professional_id')->unsigned()->nullable()
                ->references('id')->on('professionals')
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
