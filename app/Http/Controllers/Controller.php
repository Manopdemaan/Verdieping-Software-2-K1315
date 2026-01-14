<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DspReportRecord;
use App\Models\Status;

class Controller extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $records = DspReportRecord::with('status')->paginate(10);
        $statuses = Status::all();

        return view('welcome', compact('records', 'statuses'));
    }

    public function showUpdateForm()
    {
        $records = DspReportRecord::with('status')->paginate(10);
        $statuses = Status::all();

        return view('welcome', compact('records', 'statuses'));
    }

    public function updateStatus(Request $request)
    {
        $reports = $request->input('reports', []);

        foreach ($reports as $reportId => $statusId) {
            DspReportRecord::where('id', $reportId)
                ->update(['dsp_report_record_status_id' => $statusId]);
        }

        return redirect()->route('home');
    }
}
