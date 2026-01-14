<?php

// database/migrations/2025_03_12_090913_add_status_id_to_dsp_report_records_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToDspReportRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('dsp_report_records', function (Blueprint $table) {
            $table->foreignId('dsp_report_record_status_id')->nullable()->constrained('dsp_report_record_statussen')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('dsp_report_records', function (Blueprint $table) {
            $table->dropForeign(['dsp_report_record_status_id']);
            $table->dropColumn('dsp_report_record_status_id');
        });
    }
}
