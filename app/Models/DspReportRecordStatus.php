<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DspReportRecordStatus extends Model
{
    use HasFactory;

    protected $table = 'dsp_report_record_statussen'; // De naam van de status tabel
    protected $fillable = ['report_record_status'];

    // Relatie naar de DspReportRecord
    public function records()
    {
        return $this->hasMany(DspReportRecord::class, 'dsp_report_record_status_id');
    }
}
