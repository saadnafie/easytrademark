<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('discount_code');
            $table->string('alias');
            $table->integer('discount_amount');
            $table->boolean('is_percentage')->default(0);
            $table->boolean('is_date_range')->default(0);
            $table->date('start_from')->nullable();
            $table->date('end_at')->nullable();
            $table->integer('allowed_num_of_use')->nullable();
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
        Schema::dropIfExists('discounts');
    }
}
