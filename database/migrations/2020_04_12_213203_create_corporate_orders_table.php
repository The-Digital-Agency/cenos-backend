<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_orders', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('rep_name');
            $table->string('address');
            $table->string('rep_number');
            $table->string('rep_email');
            $table->dateTime('delivery_date');
            $table->json('items');
            $table->integer('order_amount')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('channel')->default('website');
            $table->foreignId('location_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->bigInteger('logistics_id')->nullable();
            $table->json('logistics')->nullable();

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
        Schema::dropIfExists('corporate_orders');
    }
}
