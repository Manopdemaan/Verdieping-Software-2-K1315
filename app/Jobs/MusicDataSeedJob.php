<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UnpackCsvJob;

class MusicDataSeedJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Constructor logic indien nodig
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ophalen van alle CSV-bestanden uit de storage map
        $files = Storage::files('csv');

        if (empty($files)) {
            \Log::warning("⚠️ Geen CSV-bestanden gevonden in storage/app/csv/");
            return;
        }

        foreach ($files as $file) {
            $filename = basename($file);
            $csvPath = storage_path("app/{$file}");

            \Log::info("✅ Verwerken van bestand:: {$filename}");

            // Dispatch de job om het CSV-bestand uit te pakken
            UnpackCsvJob::dispatch($csvPath); // De UnpackCsvJob is verantwoordelijk voor het lezen en verwerken van de CSV
        }
    }
}

