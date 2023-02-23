<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->default('LG');
            $table->string('billing_phone')->nullable();
            $table->integer('billing_discount')->default(0);
            $table->string('billing_discount_code')->nullable();
            $table->integer('billing_subtotal');
            $table->integer('billing_tax')->default(0);
            $table->integer('billing_total');
            $table->string('payment_ref')->nullable();
            $table->string('invoice_code')->nullable();
            $table->string('payment_gateway')->default('paystack');
            $table->string('payment_status')->default('unpaid');
            $table->string('order_status')->default('unconfirmed');
            $table->string('channel')->default('website');
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('logistics_id')->nullable();
            $table->json('logistics')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('delivery_window')->nullable();
            $table->string('delivery_option')->default('delivery');
            $table->text('items')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
