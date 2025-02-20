<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Jobs\UnpackCsvJob;

class MusicDataSeeder extends Seeder
{
    public function run()
    {
        // Debug output om het pad te zien
        $storagePath = storage_path('app/csv');
        $this->command->info("Absolute storage pad: {$storagePath}");

        // Ophalen van alle CSV-bestanden uit de storage map
        $files = scandir($storagePath); // Kijkt in storage/app/csv/

        // Filter alleen de .csv bestanden
        $files = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
        });

        $this->command->info("Gevonden bestanden: " . implode(', ', $files));

        if (empty($files)) {
            $this->command->warn("⚠️ Geen CSV-bestanden gevonden in storage/app/csv/");
            return;
        }

        foreach ($files as $file) {
            $this->command->info("✅ Verwerken van bestand:: {$file}");

            $csvPath = "csv/{$file}"; // Pad voor de job (relatief)

            // Dispatch de job om het CSV-bestand uit te pakken
            UnpackCsvJob::dispatch($csvPath); // Gebruik het relatieve pad voor de job
        }
    }
}
