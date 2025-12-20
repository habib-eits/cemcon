@extends('template.tmp')

@section('title', 'HR')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $pagetitle }}</h4>
                            <div class="page-title-right">
                                <h5 class="mb-0">{{ dateformatman($date) }}</h5>
                                <a href="{{ route('attendances.index') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light ms-3">
                                    <i class="mdi mdi-arrow-left me-1"></i> Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1. Fixed Salary -->
                @if ($fixed->count() > 0)
                    <div class="col-12 mb-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Fixed Salary ({{ $fixed->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fixed as $emp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $emp->FullName }}</td>
                                                <td>{{ $emp->JobTitleName }}</td>
                                                <td>{{ $emp->JobNo ?? '-' }}</td>
                                                <td>
                                                    @if ($emp->Attendance == 1)
                                                        <span class="badge bg-success">Present</span>
                                                    @elseif($emp->Attendance == 0.5)
                                                        <span class="badge bg-warning">Half Day</span>
                                                    @elseif($emp->Attendance == 0)
                                                        <span class="badge bg-danger">Absent</span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 2. Fixed + Overtime -->
                @if ($fixed_ot->count() > 0)
                    <div class="col-12 mb-4">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Fixed Salary + Overtime ({{ $fixed_ot->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Attendance</th>
                                            <th>OT (Hours)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fixed_ot as $emp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $emp->FullName }}</td>
                                                <td>{{ $emp->JobTitleName }}</td>
                                                <td>{{ $emp->JobNo ?? '-' }}</td>
                                                <td>
                                                    @if ($emp->Attendance == 1)
                                                        <span class="badge bg-success">P</span>
                                                    @elseif($emp->Attendance == 0.5)
                                                        <span class="badge bg-warning">Half</span>
                                                    @elseif($emp->Attendance == 0)
                                                        <span class="badge bg-danger">A</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $emp->OverTime > 0 ? $emp->OverTime : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 3. Hourly Paid -->
                @if ($hourly->count() > 0)
                    <div class="col-12 mb-4">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Hourly Paid ({{ $hourly->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Hours Worked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hourly as $emp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $emp->FullName }}</td>
                                                <td>{{ $emp->JobTitleName }}</td>
                                                <td>{{ $emp->JobNo ?? '-' }}</td>
                                                <td>{{ $emp->PerHour > 0 ? $emp->PerHour : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 4. Per Day -->
                @if ($perday->count() > 0)
                    <div class="col-12 mb-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Per Day ({{ $perday->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Days Worked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perday as $emp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $emp->FullName }}</td>
                                                <td>{{ $emp->JobTitleName }}</td>
                                                <td>{{ $emp->JobNo ?? '-' }}</td>
                                                <td>{{ $emp->PerDay > 0 ? $emp->PerDay : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- No Data -->
                @if ($attendance->count() == 0)
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h5>No attendance recorded for {{ dateformatman($date) }}</h5>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
