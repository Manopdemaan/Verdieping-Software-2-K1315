<?php

namespace App\Jobs;

use App\Services\CsvFiles\Extract\ExtractGzService;
use App\Services\CsvFiles\Extract\ExtractZipService;
use App\Models\CsvFile; // Zorg ervoor dat je de juiste namespace gebruikt
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UnpackCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected CsvFile $csvFile;

    /**
     * Create a new job instance.
     *
     * @param CsvFile $csvFile
     */
    public function __construct(CsvFile $csvFile)
    {
        $this->csvFile = $csvFile;
    }

    public function handle(): void
    {
        $filePath = $this->csvFile->getFileName(); // Bestandsnaam ophalen
        $extension = $this->csvFile->extention; // // Extensie ophalen en dit moest naar boven verplaats worden(al gedaan)

        // Controleer of het bestand bestaat
        if (!Storage::exists($filePath)) {
            Log::error("❌ CSV-bestand niet gevonden: {$filePath}");
            return;
        }

        if ($extension === 'zip') {
            $extractService = new ExtractZipService($this->csvFile);
            $extractService->extract();
        } elseif ($extension === 'gz') {
            $extractService = new ExtractGzService($this->csvFile);
            $extractService->extract();
        }

        $this->csvFile->is_extracted = 1;
        $this->csvFile->is_processed = 0;
        $this->csvFile->save();

        // ProcessCsvJob aanroepen
        dispatch(new ProcessCsvJob($this->csvFile));
    }

    public static function schedule()
    {
        // Dit kan nu leeg blijven of verder aangepast worden indien nodig
        $files = CsvFile::where('is_extracted', 0)->get();
        foreach ($files as $file) {
            dispatch(new UnpackCsvJob($file));
        }
    }
}
