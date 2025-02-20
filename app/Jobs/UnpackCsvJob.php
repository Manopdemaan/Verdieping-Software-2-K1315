<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessCsvJob;

class UnpackCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
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
        // Controleer of het bestand bestaat
        if (!Storage::exists($this->filePath)) {
            \Log::error("❌ CSV-bestand niet gevonden: {$this->filePath}");
            return;
        }

        // Markeer bestand als uitgepakt in de database
        DB::table('csv_files')->updateOrInsert(
            ['filename' => basename($this->filePath)],
            [
                'original_path' => $this->filePath,
                'size' => Storage::size($this->filePath),
                'extension' => 'csv',
                'is_extracted' => 1, // Alleen dit markeren
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        \Log::info("✅ Bestand gemarkeerd als uitgepakt: {$this->filePath}");

        // Start ProcessCsvJob
        ProcessCsvJob::dispatch($this->filePath);
    }
}
