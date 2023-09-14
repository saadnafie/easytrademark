<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostAfterDiscountToTrademarkCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trademark_countries', function (Blueprint $table) {
            $table->integer('discount_id')->unsigned()->nullable()->after('sub_total');
            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->float('sub_total_after_discount')->default(0.00)->after('discount_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trademark_comments', function (Blueprint $table) {
            //
        });
    }
}
