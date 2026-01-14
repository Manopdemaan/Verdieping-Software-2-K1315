<?php

// database/migrations/2025_03_11_092642_create_dsp_report_record_statussen_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDspReportRecordStatussenTable extends Migration
{
    public function up()
    {
        Schema::create('dsp_report_record_statussen', function (Blueprint $table) {
            $table->id();
            $table->string('report_record_status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dsp_report_record_statussen');
    }
}
