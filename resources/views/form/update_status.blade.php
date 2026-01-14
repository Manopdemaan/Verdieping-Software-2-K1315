<form method="POST" action="{{ route('update-status') }}">
    @csrf
    <table>
        <thead>
        <tr>
            <th>Identifier</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{ $record->identifier }}</td>
                <td>
                    <select name="reports[{{ $record->id }}]">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}"
                                    @if($status->id == $record->dsp_report_record_status_id) selected @endif>
                                {{ $status->report_record_status }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button type="submit">Opslaan</button>
</form>
