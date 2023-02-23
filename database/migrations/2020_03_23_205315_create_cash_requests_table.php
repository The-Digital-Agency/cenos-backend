<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('itemRequest');
            $table->integer('amount');
            $table->date('date_of_expense');
            $table->string('expense_type');
            $table->string('approval_type');
            $table->string('user');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('cash_requests');
    }
}
