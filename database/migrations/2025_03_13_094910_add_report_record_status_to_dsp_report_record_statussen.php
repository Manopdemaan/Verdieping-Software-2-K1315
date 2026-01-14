<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportRecordStatusToDspReportRecordStatussen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsp_report_record_statussen', function (Blueprint $table) {
            // Voeg een kolom 'report_record_status' toe
            $table->string('report_record_status')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsp_report_record_statussen', function (Blueprint $table) {
            // Verwijder de kolom als de migratie wordt teruggedraaid
            $table->dropColumn('report_record_status');
        });
    }
}
