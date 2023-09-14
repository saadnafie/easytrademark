<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('communities', function (Blueprint $table) {
//            $table->renameColumn('title', 'title_en');
//            $table->renameColumn('country', 'country_en');
//            $table->renameColumn('description', 'description_en');
//        });

        Schema::table('communities', function (Blueprint $table) {
            $table->string('title_ar')->after('title');
            $table->string('country_ar')->after('country');
            $table->text('description_ar')->after('description');
            $table->string('title_zh')->after('title_ar');
            $table->string('country_zh')->after('country_ar');
            $table->text('description_zh')->after('description_ar');
            $table->string('title_tr')->after('title_zh');
            $table->string('country_tr')->after('country_zh');
            $table->text('description_tr')->after('description_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            //
        });
    }
}
