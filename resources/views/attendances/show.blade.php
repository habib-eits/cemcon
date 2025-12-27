@extends('tmp')
@section('title', 'Attendance View')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @foreach ($salaryTypes as $type)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-light fw-bold">
                            <div class="col-md-3">
                                <label for="attendance_date" class="form-label">Date</label>
                                <input type="text" id="attendance_date" class="form-control" 
                                    value="{{ isset($attendance->date) ? \Carbon\Carbon::parse($attendance->date)->format('d M, Y') : '' }}" 
                                    readonly>
                            </div>
                        </div>
                        <div class="card-header bg-light fw-bold">
                            {{ $type['name'] }}
                        </div>

                        <div class="card-body">
                            @if ($type['employees']->count() < 1)
                                <p class="text-center text-warning mb-0">No Employee</p>
                            @else
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:5%">S#</th>
                                            <th style="width:15%">Employee</th>
                                            <th style="width:15%">Designation</th>
                                            <th style="width:20%">Project</th>
                                            <th style="width:10%">Status</th>
                                            <th style="width:10%">Office Hrs</th>
                                            <th style="width:10%">Worked Hrs</th>
                                            <th style="width:10%">OT</th>
                                            <th style="width:10%">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($type['employees'] as $index => $row)
                                            <tr data-id="{{ $row->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row->employee->FirstName ?? 'N/A' }}</td>
                                                <td>{{ $row->employee->jobTitle->JobTitleName ?? 'N/A' }}</td>
                                                <td>{{ $row->job->JobNo ?? 'N/A' }}</td>
                                                <td class="status-cell">
                                                    @if ($row->status == 1)
                                                        <span class="badge bg-success status-badge" data-value="1">Present</span>
                                                    @elseif ($row->status == 0.5)
                                                        <span class="badge bg-warning status-badge" data-value="0.5">Half</span>
                                                    @else
                                                        <span class="badge bg-danger status-badge" data-value="0">Absent</span>
                                                    @endif
                                                    <select class="form-select form-select-sm status-select d-none">
                                                        <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>Present</option>
                                                        <option value="0.5" {{ $row->status == 0.5 ? 'selected' : '' }}>Half</option>
                                                        <option value="0" {{ $row->status == 0 ? 'selected' : '' }}>Absent</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control form-control-sm office_hours"
                                                        value="{{ $row->office_hours }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                        class="form-control form-control-sm worked_hours"
                                                        value="{{ $row->worked_hours }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                        class="form-control form-control-sm over_time"
                                                        value="{{ $row->over_time }}"
                                                        readonly>
                                                </td>
                                                <td class="text-center" style="width:140px">
                                                    <button class="btn btn-outline-secondary btn-sm edit-row" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>

                                                    <button class="btn btn-success btn-sm save-row d-none" title="Save">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                    <button class="btn btn-danger btn-sm cancel-row d-none" title="Cancel">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<script>
$(document).on('click', '.edit-row', function () {
    let row = $(this).closest('tr');

    $('tbody tr').find('input').prop('readonly', true);
    $('tbody tr').find('.status-badge').removeClass('d-none');
    $('tbody tr').find('.status-select').addClass('d-none');
    $('.save-row, .cancel-row').addClass('d-none');
    $('.edit-row').removeClass('d-none');

    row.find('input').prop('readonly', false);
    row.find('.status-badge').addClass('d-none');
    row.find('.status-select').removeClass('d-none');
    row.find('.edit-row').addClass('d-none');
    row.find('.save-row, .cancel-row').removeClass('d-none');

    row.data('original', {
        status: row.find('.status-select').val(),
        office_hours: row.find('.office_hours').val(),
        worked_hours: row.find('.worked_hours').val(),
        over_time: row.find('.over_time').val()
    });
});

$(document).on('click', '.save-row', function () {
    let row = $(this).closest('tr');
    let statusVal = row.find('.status-select').val();

    let data = {
        _token: '{{ csrf_token() }}',
        id: row.data('id'),
        status: statusVal,
        office_hours: row.find('.office_hours').val(),
        worked_hours: row.find('.worked_hours').val(),
        over_time: row.find('.over_time').val(),
    };

    $.post("{{ route('update-attandence-record') }}", data, function () {
        let badge = row.find('.status-badge');
        if (statusVal == 1) {
            badge.attr('class', 'badge bg-success status-badge').text('Present');
        } else if (statusVal == 0.5) {
            badge.attr('class', 'badge bg-warning status-badge').text('Half');
        } else {
            badge.attr('class', 'badge bg-danger status-badge').text('Absent');
        }

        badge.removeClass('d-none');
        row.find('.status-select').addClass('d-none');
        row.find('input').prop('readonly', true);
        row.find('.save-row, .cancel-row').addClass('d-none');
        row.find('.edit-row').removeClass('d-none');
    });
});

$(document).on('click', '.cancel-row', function () {
    let row = $(this).closest('tr');
    let original = row.data('original');

    row.find('.status-select').val(original.status);
    row.find('.office_hours').val(original.office_hours);
    row.find('.worked_hours').val(original.worked_hours);
    row.find('.over_time').val(original.over_time);

    let badge = row.find('.status-badge');
    if (original.status == 1) {
        badge.attr('class', 'badge bg-success status-badge').text('Present');
    } else if (original.status == 0.5) {
        badge.attr('class', 'badge bg-warning status-badge').text('Half');
    } else {
        badge.attr('class', 'badge bg-danger status-badge').text('Absent');
    }

    badge.removeClass('d-none');
    row.find('.status-select').addClass('d-none');
    row.find('input').prop('readonly', true);
    row.find('.save-row, .cancel-row').addClass('d-none');
    row.find('.edit-row').removeClass('d-none');
});
</script>

@endsection
