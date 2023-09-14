<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEnglishColToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('service_name', 'service_name_en');
            $table->renameColumn('service_description', 'service_description_en');
            $table->renameColumn('service_what', 'service_what_en');
            $table->renameColumn('service_why', 'service_why_en');
            $table->renameColumn('service_when', 'service_when_en');
            $table->renameColumn('service_how', 'service_how_en');
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
