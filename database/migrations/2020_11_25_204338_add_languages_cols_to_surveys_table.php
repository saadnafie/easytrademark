<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('survey_name_ar')->after('survey_name');
            $table->string('survey_name_zh')->after('survey_name_ar');
            $table->string('survey_name_tr')->after('survey_name_zh');
            $table->string('title_ar')->after('title');
            $table->string('title_zh')->after('title_ar');
            $table->string('title_tr')->after('title_zh');
            $table->text('message_ar')->after('message')->nullable();
            $table->text('message_zh')->after('message_ar')->nullable();
            $table->text('message_tr')->after('message_zh')->nullable();
            $table->text('description_ar')->after('description')->nullable();
            $table->text('description_zh')->after('description_ar')->nullable();
            $table->text('description_tr')->after('description_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            //
        });
    }
}
