<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('classes', function (Blueprint $table) {
//            $table->renameColumn('class_brief', 'class_brief_en');
//        });

        Schema::table('classes', function (Blueprint $table) {
            $table->text('class_brief_ar')->after('class_brief');
            $table->text('class_brief_zh')->after('class_brief_ar');
            $table->text('class_brief_tr')->after('class_brief_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            //
        });
    }
}
