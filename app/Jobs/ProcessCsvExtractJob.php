<?php

// Deze job haalt het bestand op en verwerkt de CSV.
namespace App\Jobs;

use App\Models\CsvFile;
use App\Models\CsvData;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCsvExtractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $fileId;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    public function handle()
    {
        // Haal bestand op uit de CsvFile model
        $file = CsvFile::find($this->fileId);

        // Logica om CSV te verwerken
        $this->parseCsv($file->original_path);
    }

    public static function schedule():void
    {

    }


}
