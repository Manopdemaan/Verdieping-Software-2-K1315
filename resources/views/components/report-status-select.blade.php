<div>
    <select name="reports[{{ $recordId }}]" class="form-select">
        @foreach($statuses as $status)
            <option value="{{ $status->id }}" {{ $currentStatusId == $status->id ? 'selected' : '' }}>
                {{ $status->report_record_status }}
            </option>
        @endforeach
    </select>

</div>
