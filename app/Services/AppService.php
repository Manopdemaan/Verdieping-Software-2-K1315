<?php

namespace App\Services;


use App\Jobs\UnpackCsvJob;
use App\Services\CsvFiles\Sqlite\SqliteConnectionService;
use Illuminate\Support\Facades\Storage;

require "CsvFiles/Sqlite/SqliteConnectionService.php";



// Geef een dynamische database naam mee
$databaseName = "example.sqlite"; // 🔄 Pas dit aan naar jouw logica
$files = Storage::files('csv');
foreach ($files as $file) {
    $filename = basename($file);
    $database = $filename;

    $service = new SqliteConnectionService($database);
}


// Define the columns for the table dynamically
$columns = [
    'col1' => 'TEXT',
    'col2' => 'TEXT',
    'col3' => 'TEXT',
    'col4' => 'TEXT'
];


$service->createTable("row_data", $columns);
$service->insertData("row_data");
