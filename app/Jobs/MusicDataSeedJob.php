<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UnpackCsvJob;

class MusicDataSeedJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ophalen van alle bestanden uit de storage map
        $files = Storage::files('csv');

        if (empty($files)) {
            \Log::warning("⚠️ Geen bestanden gevonden in storage/app/csv/");
            return;
        }

        foreach ($files as $file) {
            $filename = basename($file);
            $csvPath = storage_path("app/{$file}");

            \Log::info("✅ Verwerken van bestand: {$filename}");

            // Bepaal de extensie van het bestand
            $extension = strtolower(pathinfo($csvPath, PATHINFO_EXTENSION));

            // Bestand opslaan in database
            DB::table('csv_files')->updateOrInsert(
                ['filename' => $filename],
                [
                    'original_path' => $csvPath,
                    'size' => Storage::size($file),
                    'extension' => $extension,
                    'is_extracted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            \Log::info("✅ Bestand opgeslagen in database: {$csvPath}");
        }

        UnpackCsvJob::dispatch();

        \Log::info("✅ Alle bestanden zijn verwerkt!");
    }
}
