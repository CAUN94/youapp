<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->integer('number')->unique()->after('id');
            $table->dateTime('date')->after('number');
            $table->integer('benefit')->after('date');
            $table->integer('payment')->after('benefit');
            $table->string('bank')->after('payment');
            $table->string('method')->after('bank');
            $table->string('boucher_nr')->after('method');
            $table->string('referenc')->after('boucher_nr');
            $table->string('type')->after('referenc');
            $table->time('duration')->after('type');
            $table->longText('health_record')->after('duration');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treatments', function (Blueprint $table) {
            //
        });
    }
}
