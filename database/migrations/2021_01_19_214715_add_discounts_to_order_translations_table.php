<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountsToOrderTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_translations', function (Blueprint $table) {
            $table->integer('discount_id')->unsigned()->nullable()->after('total_price');
            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->float('total_price_after_discount')->default(0.00)->after('discount_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_translations', function (Blueprint $table) {
            //
        });
    }
}
