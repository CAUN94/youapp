<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('benefit_id');
            $table->foreign('benefit_id')->unsigned()->nullable()
                ->references('id')->on('benefits')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // $table->unsignedBigInteger('treatment_id');
            // $table->foreign('treatment_id')->unsigned()->nullable()
            //     ->references('id')->on('treatments')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefits_treatments');
    }
}
