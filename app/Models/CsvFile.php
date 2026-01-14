<?php

namespace App\Models; // Add this line

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvFile extends Model
{
    use HasFactory;

    protected $table = 'csv_files';

    protected $fillable = [
        'original_path',
        'filename',
        'size',
        'extension',
        'ftp_location',
        'local_location',
        'is_copied',
        'is_extracted',
        'is_validated',
        'is_sqlite',
        'is_mapped',
        'is_processed',
    ];

    protected $casts = [
        'is_copied' => 'boolean',
        'is_extracted' => 'boolean',
        'is_validated' => 'boolean',
        'is_sqlite' => 'boolean',
        'is_mapped' => 'boolean',
        'is_processed' => 'boolean',
    ];

    public $timestamps = false;

    public function getFileName(): string {
        return $this->local_location;
    }
}
