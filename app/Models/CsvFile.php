<?php

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

    // Zorgt ervoor dat de kolommen als booleans worden behandeld, en null blijft toegestaan
    protected $casts = [
        'is_copied' => 'boolean',
        'is_extracted' => 'boolean',
        'is_validated' => 'boolean', // ✅ Dit zorgt ervoor dat Laravel dit als een boolean behandelt
        'is_sqlite' => 'boolean',
        'is_mapped' => 'boolean',
        'is_processed' => 'boolean',
    ];

    // Timestamps uitschakelen
    public $timestamps = false;
}
