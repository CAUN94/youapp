<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_categories', function (Blueprint $table) {
            $table->id();
            $table->float('percentage')->default(0.45);
            $table->unsignedBigInteger('professional_id');
            $table->foreign('professional_id')
                ->references('id')->on('professionals')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')->on('categories')
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
        Schema::dropIfExists('professional_categories');
    }
}
