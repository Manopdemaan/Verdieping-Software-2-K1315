<?php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob; // Vergeet niet de job te importeren

class JobController extends Controller
{
    public function dispatchJob()
    {
        ExampleJob::dispatch(); // Dit dispatcht de job naar de queue

        return response()->json(['message' => 'Job dispatched']);
    }
}
