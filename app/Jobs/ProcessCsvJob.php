<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Controleer of het bestand al verwerkt is
        $csvFile = DB::table('csv_files')->where('original_path', $this->filePath)->first();

        if (!$csvFile) {
            \Log::error("❌ Bestand niet gevonden in database: {$this->filePath}");
            return;
        }

        if ($csvFile->is_extracted !== 1) {
            \Log::warning("⏳ Bestand nog niet uitgepakt: {$this->filePath}");
            return;
        }

        if ($csvFile->is_processed === 1) {
            \Log::info("✅ Bestand is al verwerkt: {$this->filePath}");
            return;
        }

        // Controleer of het bestand bestaat in de storage
        if (!Storage::exists($this->filePath)) {
            \Log::error("❌ Bestand niet gevonden in storage: {$this->filePath}");
            return;
        }

        // Lees de CSV
        $csv = Reader::createFromPath(Storage::path($this->filePath), 'r');
        $csv->setHeaderOffset(0);
        $records = Statement::create()->process($csv);

        foreach ($records as $record) {
            // Sla de gegevens op in een andere tabel, bijvoorbeeld 'processed_data'
            DB::table('processed_data')->insert([
                'filename' => basename($this->filePath),
                'data' => json_encode($record),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Update de status naar verwerkt
        DB::table('csv_files')->where('original_path', $this->filePath)->update([
            'is_processed' => 1,
            'updated_at' => now(),
        ]);

        \Log::info("✅ CSV-bestand verwerkt: {$this->filePath}");
    }
}
