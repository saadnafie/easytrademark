<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('service_name_ar')->after('service_name');
            $table->text('service_name_zh')->after('service_name_ar');
            $table->text('service_name_tr')->after('service_name_zh');
            $table->text('service_description_ar')->after('service_description');
            $table->text('service_description_zh')->after('service_description_ar');
            $table->text('service_description_tr')->after('service_description_zh');
            $table->text('service_what_ar')->after('service_what');
            $table->text('service_what_zh')->after('service_what_ar');
            $table->text('service_what_tr')->after('service_what_zh');
            $table->text('service_why_ar')->after('service_why');
            $table->text('service_why_zh')->after('service_why_ar');
            $table->text('service_why_tr')->after('service_why_zh');
            $table->text('service_when_ar')->after('service_when');
            $table->text('service_when_zh')->after('service_when_ar');
            $table->text('service_when_tr')->after('service_when_zh');
            $table->text('service_how_ar')->after('service_how');
            $table->text('service_how_zh')->after('service_how_ar');
            $table->text('service_how_tr')->after('service_how_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
}
