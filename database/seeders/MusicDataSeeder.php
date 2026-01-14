<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UnpackCsvJob;
use App\Jobs\MusicDataSeedJob; // Toegevoegd voor het dispatchen van de job
use App\Models\CsvFile; // Zorg ervoor dat je de juiste namespace gebruikt

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

        // Debug output om de gevonden bestanden te tonen
        if (!empty($files)) {
            $this->command->info("Gevonden CSV-bestanden: " . implode(', ', $files));
        } else {
            $this->command->warn("⚠️ Geen CSV-bestanden gevonden in storage/app/csv/");
            return;
        }

        foreach ($files as $file) {
            $this->command->info("✅ Verwerken van bestand: {$file}");

            // Zoek het CsvFile object in de database op basis van het bestand
            $csvFile = CsvFile::where('filename', $file)->first(); // Assuming you have a `filename` column in the `csv_files` table

            if ($csvFile) {
                // Dispatch de job om het CSV-bestand uit te pakken
                UnpackCsvJob::dispatch($csvFile); // Gebruik het CsvFile object voor de job
            } else {
                $this->command->warn("⚠️ CSV-bestand niet gevonden in de database: {$file}");
            }
        }

        // Dispatch de MusicDataSeedJob zodat deze ook wordt uitgevoerd
        MusicDataSeedJob::dispatch();

        // Bevestiging dat de seeder is voltooid
        $this->command->info("✅ MusicDataSeeder is voltooid!");
    }
}
