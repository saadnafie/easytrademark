<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToServiceHowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_how_details', function (Blueprint $table) {
            $table->string('title_ar')->after('title');
            $table->string('title_zh')->after('title_ar');
            $table->string('title_tr')->after('title_zh');
            $table->text('content_ar')->after('content');
            $table->text('content_zh')->after('content_ar');
            $table->text('content_tr')->after('content_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_how_details', function (Blueprint $table) {
            //
        });
    }
}
