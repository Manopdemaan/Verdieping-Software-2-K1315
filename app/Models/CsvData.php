<?php

// Een model voor de gegevens die uit de CSV worden gehaald en in de database worden opgeslagen
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvData extends Model
{
    use HasFactory;

    // De naam van de tabel
    protected $table = 'csv_data';

    // Vulbare velden
    protected $fillable = ['column1', 'column2', 'column3'];

    // Zet timestamps uit, indien je geen timestamp wilt
    public $timestamps = true;
}
