<?php

namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DspReportRecord extends Model
{
    use HasFactory;

    // Koppel de juiste tabel
    protected $table = 'dsp_report_records'; // Zorg ervoor dat deze naam klopt met je database-tabel

    // Voeg de velden toe die ingevuld kunnen worden (Mass Assignment)
    protected $fillable = [
        'identifier',
        'dsp',
        'reporting_period',
        'accounting_period',
        'currency',
        'total_gross',
        'dsp_report_record_status_id', // Dit is de foreign key naar de status
    ];

    // Relatie naar de status
// app/Models/DspReportRecord.php
    public function status()
    {
        return $this->belongsTo(Status::class, 'dsp_report_record_status_id');
    }

}
