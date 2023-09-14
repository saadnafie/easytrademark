<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToApplicantTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_types', function (Blueprint $table) {
            //$table->renameColumn('type', 'type_en');
            $table->string('type_zh')->after('type_ar');
            $table->string('type_tr')->after('type_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_types', function (Blueprint $table) {
            //
        });
    }
}
