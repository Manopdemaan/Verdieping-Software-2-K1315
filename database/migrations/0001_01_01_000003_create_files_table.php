<?php

// Vergeet niet om database-migraties te maken voor de tabellen files en csv_data in SQLite.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('csv_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_path');
            $table->string('filename');
            $table->integer('size');
            $table->string('extension');
            $table->string('ftp_location')->nullable();
            $table->string('local_location')->nullable();
            $table->tinyInteger('is_copied')->nullable();
            $table->tinyInteger('is_extracted')->nullable();
            $table->tinyInteger('is_validated')->nullable();
            $table->tinyInteger('is_sqlite')->nullable();
            $table->tinyInteger('is_mapped')->nullable();
            $table->tinyInteger('is_processed')->nullable();
            $table->string('processed_by')->nullable(); // Toegevoegd
            $table->timestamp('processed_at')->nullable(); // Optioneel: als je deze kolom ook wilt
            $table->timestamps(); // Dit voegt created_at en updated_at toe
        });
    }

    public function down()
    {
        Schema::dropIfExists('csv_files'); // Zorg ervoor dat de juiste tabelnaam hier staat
    }
}
