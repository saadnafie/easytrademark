<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGuideImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_guide_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_guide_id');
            $table->foreign('user_guide_id')->references('id')->on('user_guides')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_guide_images');
    }
}
