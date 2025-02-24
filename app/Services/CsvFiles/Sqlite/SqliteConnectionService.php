<?php

namespace App\Services\CsvFiles\Sqlite;

use PDO;
use PDOException;
use RuntimeException;

class SqliteConnectionService
{

    protected string $fileLocation;
    protected PDO $connection;


    public $dbPath = '../../storage/map1/';
    public $database = "bx.sqlite";
    public $row_data = [
    ['col1' => 'a1', 'col2' => 'b1', 'col3' => 'c1', 'col4' => 'd1'],
    ['col1' => 'a', 'col2' => 'b', 'col3' => 'c', 'col4' => 'd'],
    ['col1' => 'a', 'col2' => 'b', 'col3' => 'c', 'col4' => 'd'],
    ];

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $fullPath = $this->dbPath . $this->database;
            $this->connection = new PDO("sqlite:" . $fullPath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✅ Connected to SQLite database: " . $fullPath . "\n";
        } catch (PDOException $e) {
            echo "Failed to connect to SQLite database: " . $fullPath . "\n";
        }
    }

    // Create a table dynamically based on the table name and columns provided.
    public function createTable(string $table, array $columns)
    {
        // Build the CREATE TABLE query
        $columnsQuery = [];
        foreach ($columns as $column => $type) {
            $columnsQuery[] = "$column $type";
        }
        $columnsSql = implode(", ", $columnsQuery);

        $sql = 'CREATE TABLE ' . $table . ' (' . $columnsSql . ')';

        // Execute the query to create the table
        try {
            $this->connection->exec($sql);
            echo "✅ Table $table created successfully.\n";
        } catch (PDOException $e) {
            echo "❌ Failed to create table $table: " . $e->getMessage() . "\n";
        }
    }

    public function insertData(string $table) {
        $stmt = $this->connection->prepare("INSERT INTO $table (col1, col2, col3, col4) VALUES (?, ?, ?, ?)");
        foreach ($this->row_data as $row) {
            $stmt->execute([$row['col1'], $row['col2'], $row['col3'], $row['col4']]);
        }
        echo "✅ Data inserted successfully into $table.\n";
    }
}
