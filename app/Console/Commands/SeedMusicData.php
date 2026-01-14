<?php

namespace App\Console\Commands;

use App\Jobs\MusicDataSeedJob;
use Illuminate\Console\Command;

class SeedMusicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-music-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed music data from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Dispatch the MusicDataSeedJob to the queue
       dispatch_sync(new MusicDataSeedJob());

        $this->info('✅ Music data seeding job has been dispatched!');
    }
}
