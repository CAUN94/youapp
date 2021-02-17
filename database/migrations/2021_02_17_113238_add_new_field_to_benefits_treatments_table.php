<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToBenefitsTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('benefits_treatments', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id');
            $table->foreign('treatment_id')->unsigned()->nullable()
                ->references('id')->on('treatments')
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
        Schema::table('benefits_treatments', function (Blueprint $table) {
            //
        });
    }
}
