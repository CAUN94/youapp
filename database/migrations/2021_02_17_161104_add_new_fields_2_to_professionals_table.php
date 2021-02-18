<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFields2ToProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('goal');
            $table->dropColumn('medilink');
        });
        Schema::table('professionals', function (Blueprint $table) {
            $table->string('rut')->unique()->after('id');
            $table->string('email')->unique()->after('rut');
            $table->integer('goal')->after('email');
            $table->string('medilink')->unique()->after('goal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professionals', function (Blueprint $table) {
            //
        });
    }
}
