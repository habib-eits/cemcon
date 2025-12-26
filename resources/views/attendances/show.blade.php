@extends('tmp')
@section('title', 'Attendance')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title & Header Info -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Attendance Record</h4>
                            <div class="text-end">
                                <p class="mb-0"><strong>Branch:</strong> {{ $attendance->branch->BranchName ?? '-' }}</p>
                                <p class="mb-0"><strong>Date:</strong>
                                    {{ $attendance->date }}</p>
                                <p class="mb-0"><strong>Office Hours:</strong> {{ $attendance->office_hours }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                @foreach ($salaryTypes as $type)
                    <div class="col-md-12">
                        <div class="card-header bg-light fw-bold"> {{ $type['name'] }} ({{ $type['employees']->count() }}
                            Employees)</div>
                        <div class="card">
                            <div class="card-body">
                                @if ($type['employees']->count() == 0)
                                    <p class="text-center text-warning">No Employee</p>
                                @else
                                    <table class="table table-sm">
                                        <thead class="">
                                            <tr>
                                                <th style="width: 5%">S#</th>
                                                <th style="width: 15%">Employee</th>
                                                <th style="width: 10%">Designation</th>
                                                <th style="width: 30%">Project</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Office Hrs</th>
                                                <th style="width: 10%">Worked Hrs</th>
                                                <th style="width: 10%">OT</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($type['employees'] as $detail)
                                                @php
                                                    $employee = $detail->employee;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $employee->FirstName ?? '' }} {{ $employee->LastName ?? '' }}
                                                    </td>
                                                    <td>{{ $employee->jobTitle->JobTitleName ?? '-' }}</td>
                                                    <td>{{ $detail->job->JobNo ?? '-' }}</td>
                                                    <td>
                                                        @if ($detail->status == '1')
                                                            <span class="badge bg-success">Present</span>
                                                        @elseif($detail->status == '0')
                                                            <span class="badge bg-danger">Absent</span>
                                                        @elseif($detail->status == '0.5')
                                                            <span class="badge bg-warning">Half Day</span>
                                                        @else
                                                            <span class="badge bg-secondary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $detail->office_hours }}</td>
                                                    <td>{{ $detail->worked_hours }}</td>
                                                    <td>{{ $detail->over_time }}</td>
                                                    <td>
                                                        <a href="#" onclick="editAttendanceDetail(this)"
                                                            class="text-secondary" data-detail-id="{{ $detail->id }}"
                                                            data-employee-id="{{ $detail->employee_id }}"
                                                            data-employee-name="{{ $detail->employee->FirstName }} {{ $detail->employee->LastName }}"
                                                            data-status="{{ $detail->status }}"
                                                            data-job-id="{{ $detail->job_id }}"
                                                            data-worked="{{ $detail->worked_hours }}"
                                                            data-ot="{{ $detail->over_time }}">
                                                            <i class="mdi mdi-pencil font-size-18 align-middle"></i>
                                                        </a>

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

    <!-- Edit Modal -->
    @include('attendances.partials.edit_attendance_modal')

    <script>
        function editAttendanceDetail(button) {

            const data = button.dataset;

            // Debug (optional)
            console.log(data);

            // Fill fields
            $('#employeeName').val(data.employeeName);

            $('#status-edit').val(data.status);

            $('#job_id').val(data.jobId).trigger('change');

            $('#worked_hours').val(data.worked || 0);
            $('#over_time').val(data.ot || 0);

            // Set form action
            $('#attendanceEditForm').attr(
                'action',
                `/attendances/{{ $attendance->id }}/detail/${data.detailId}`
            );

            // Show modal
            $('#attendanceEditModal').modal('show');
        }
    </script>

@endsection
