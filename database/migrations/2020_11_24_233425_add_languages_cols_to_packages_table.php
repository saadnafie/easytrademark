<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColsToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('package_ar')->after('package');
            $table->string('package_zh')->after('package_ar');
            $table->string('package_tr')->after('package_zh');
            $table->string('package_type_ar')->after('package_type');
            $table->string('package_type_zh')->after('package_type_ar');
            $table->string('package_type_tr')->after('package_type_zh');
            $table->text('package_details_ar')->after('package_details');
            $table->text('package_details_zh')->after('package_details_ar');
            $table->text('package_details_tr')->after('package_details_zh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
}
