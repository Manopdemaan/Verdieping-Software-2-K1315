<?php

namespace App\Jobs;

use App\Models\CsvFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ProcessCsvExtractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected int $fileId;

    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    public function handle()
    {
        // Haal bestand op uit de CsvFile model
        $file = CsvFile::find($this->fileId);

        // Controleer of het bestand een ZIP-bestand is
        if (pathinfo($file->original_path, PATHINFO_EXTENSION) === 'zip') {
            $this->unzipAndProcess($file->original_path);
        } else {
            // Als het geen ZIP-bestand is, verwerk het CSV-bestand direct
            $this->parseCsv($file->original_path);
        }
    }

    protected function unzipAndProcess($zipPath)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipPath) === true) {
            $extractPath = storage_path('app/csv/extracted'); // Of een andere gewenste pad

            // Maak de map aan als deze nog niet bestaat
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0755, true);
            }

            $zip->extractTo($extractPath);
            $zip->close();

            // Verwerk de uitgepakte CSV-bestanden
            foreach (glob("{$extractPath}/*.csv") as $csvFile) {
                // Dispatch de job om het CSV-bestand te verwerken
                ProcessCsvJob::dispatch($csvFile);
            }
        } else {
            \Log::error("❌ Kan ZIP-bestand niet openen: {$zipPath}");
        }
    }

    protected function parseCsv($csvPath)
    {
        // Implementeer hier de logica om het CSV-bestand te verwerken
    }
}

