<?php

// app/Models/Status.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DspReportRecord;

class Status extends Model
{
    use HasFactory;

    protected $table = 'dsp_report_record_statussen'; // Zorg ervoor dat de tabelnaam overeenkomt met je database

    protected $fillable = ['report_record_status']; // Voeg hier de kolom toe die je in de tabel hebt

    // Relatie met de DspReportRecord
    public function dspReportRecords()
    {
        return $this->hasMany(DspReportRecord::class, 'dsp_report_record_status_id');
    }
}
