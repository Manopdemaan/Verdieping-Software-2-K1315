<?php

namespace App\Services;

use App\Services\CsvFiles\Sqlite\SqliteConnectionService;

require "CsvFiles/Sqlite/SqliteConnectionService.php";


$service = new SqliteConnectionService();

// Define the columns for the table dynamically
$columns = [
    'col1' => 'TEXT',
    'col2' => 'TEXT',
    'col3' => 'TEXT',
    'col4' => 'TEXT'
];


$service->createTable("row_data", $columns);
$service->insertData("row_data");
