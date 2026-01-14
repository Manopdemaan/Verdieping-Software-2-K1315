@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>DSP Report Records</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('update-status') }}" method="POST">
                @csrf
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Identifier</th>
                        <th>DSP</th>
                        <th>Reporting Period</th>
                        <th>Accounting Period</th>
                        <th>Currency</th>
                        <th>Total Gross</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{ $record->identifier }}</td>
                            <td>{{ $record->dsp }}</td>
                            <td>{{ $record->reporting_period }}</td>
                            <td>{{ $record->accounting_period }}</td>
                            <td>{{ $record->currency }}</td>
                            <td>{{ $record->total_gross }}</td>
                            <td>
                                <x-report-status-select :recordId="$record->id" :currentStatusId="$record->dsp_report_record_status_id" />

                                <input type="hidden" name="reports_original_value[{{ $record->id }}]"
                                       value="{{ $record->dsp_report_record_status_id }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>

            <!-- Paginering links -->
            {{ $records->links() }}
        </div>
    </div>
@endsection
