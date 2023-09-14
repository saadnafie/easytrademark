<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->string('answer_ar')->after('answer');
            $table->string('answer_zh')->after('answer_ar');
            $table->string('answer_tr')->after('answer_zh');
            $table->text('final_answer_message_ar')->after('final_answer_message')->nullable();
            $table->text('final_answer_message_zh')->after('final_answer_message_ar')->nullable();
            $table->text('final_answer_message_tr')->after('final_answer_message_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            //
        });
    }
}
