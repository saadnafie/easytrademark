<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            $table->string('nationality_ar')->after('nationality');
            $table->string('nationality_zh')->after('nationality_ar');
            $table->string('nationality_tr')->after('nationality_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            //
        });
    }
}
