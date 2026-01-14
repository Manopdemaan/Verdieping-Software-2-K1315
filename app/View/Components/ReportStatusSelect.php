<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Status;
class ReportStatusSelect extends Component
{
    public $recordId;
    public $currentStatusId;
    public $statuses;

    // Constructor om gegevens door te geven
    public function __construct($recordId, $currentStatusId)
    {
        $this->recordId = $recordId;
        $this->currentStatusId = $currentStatusId;
        $this->statuses = Status::all(); // Haal alle statussen op uit de database
    }

    /**
     * Retourneert de Blade-weergave van de component.
     */
    public function render()
    {
        return view('components.report-status-select');
    }
}
