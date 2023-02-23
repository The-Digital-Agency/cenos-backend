<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_gift')->default(false)->after('items');
            $table->text('gift_note')->after('is_gift')->nullable();
            $table->string('receiver_name')->after('gift_note')->nullable();
            $table->string('receiver_phone')->after('receiver_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_gift');
            $table->dropColumn('gift_note');
            $table->dropColumn('receiver_name');
            $table->dropColumn('receiver_phone');
        });
    }
}
