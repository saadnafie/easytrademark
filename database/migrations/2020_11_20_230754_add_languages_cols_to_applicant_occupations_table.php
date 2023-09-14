<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToApplicantOccupationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_occupations', function (Blueprint $table) {
            //$table->renameColumn('occupation', 'occupation_en');
            $table->string('occupation_zh')->after('occupation_ar');
            $table->string('occupation_tr')->after('occupation_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_occupations', function (Blueprint $table) {
            //
        });
    }
}
