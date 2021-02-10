+<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('movemente_id');
            $table->string('description');
            $table->string('amount');
            $table->string('currency');
            $table->datetime('date');
            $table->datetime('transaction_date');
            $table->string('type');
            $table->string('recipient_account')->nullable($value = true);
            $table->string('rut')->nullable($value = true);
            $table->string('holder_name')->nullable($value = true);
            $table->string('account_number')->nullable($value = true);
            $table->string('bank_name')->nullable($value = true);
            $table->string('comment')->nullable($value = true);
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
        Schema::dropIfExists('transfers');
    }
}
