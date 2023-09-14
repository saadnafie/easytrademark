<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question_ar')->after('question');
            $table->text('question_zh')->after('question_ar');
            $table->text('question_tr')->after('question_zh');
            $table->text('answer_ar')->after('answer');
            $table->text('answer_zh')->after('answer_ar');
            $table->text('answer_tr')->after('answer_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            //
        });
    }
}
