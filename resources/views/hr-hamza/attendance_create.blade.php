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
                            <h4 class="mb-sm-0 font-size-18">Attendance Entry</h4>
                            <div class="page-title-right">
                                <a href="{{ URL('/Attendance') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                    <i class="mdi mdi-arrow-left me-1"></i> Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if (session('error'))
                    <div class="alert alert-{{ session('class', 'danger') }} p-3">
                        <strong>{{ session('error') }}</strong>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger pt-3 border-3 bg-danger text-white">
                        <p class="font-weight-bold">There were some problems with your input.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('attendances.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="Date" class="form-label">Date *</label>
                            <input type="date" class="form-control form-control-sm" name="Date" id="Date"
                                value="{{ date('Y-m-d') }}" style="width: 150px;">
                        </div>
                    </div>

                    <!-- ==================== 1. Fixed Salary ==================== -->
                    @if ($fixed->count() > 0)
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Fixed Salary ({{ $fixed->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-sm table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>S#</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fixed as $value)
                                            <tr>
                                                <td>
                                                    {{ $value->EmployeeID }}
                                                    <input type="hidden" name="EmployeeID[]"
                                                        value="{{ $value->EmployeeID }}">
                                                    <input type="hidden" name="SalaryTypeID[]"
                                                        value="{{ $value->AllowanceListID }}">
                                                </td>
                                                <td>{{ $value->FullName }}</td>
                                                <td>{{ $value->JobTitleName }}</td>
                                                <td>
                                                    <select name="JobID[]" class="form-select form-select-sm">
                                                        @foreach ($job as $j)
                                                            <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="Attendance[]" class="form-select form-select-sm"
                                                        style="width: 80px;">
                                                        <option value="1">P</option>
                                                        <option value="0">A</option>
                                                        <option value="0.5">Half</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- ==================== 2. Fixed + Overtime ==================== -->
                    @if ($fixed_ot->count() > 0)
                        <div class="card mb-4 border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Fixed Salary + Overtime ({{ $fixed_ot->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-sm table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>S#</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Attendance</th>
                                            <th>Overtime (Hours)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fixed_ot as $value)
                                            <tr>
                                                <td>
                                                    {{ $value->EmployeeID }}
                                                    <input type="hidden" name="EmployeeID[]"
                                                        value="{{ $value->EmployeeID }}">
                                                    <input type="hidden" name="SalaryTypeID[]"
                                                        value="{{ $value->AllowanceListID }}">
                                                </td>
                                                <td>{{ $value->FullName }}</td>
                                                <td>{{ $value->JobTitleName }}</td>
                                                <td>
                                                    <select name="JobID[]" class="form-select form-select-sm">
                                                        @foreach ($job as $j)
                                                            <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="Attendance[]" class="form-select form-select-sm"
                                                        style="width: 80px;">
                                                        <option value="1">P</option>
                                                        <option value="0">A</option>
                                                        <option value="0.5">Half</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="OT[]" step="0.5" min="0"
                                                        class="form-control form-control-sm" style="width: 80px;">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- ==================== 3. Hourly Paid ==================== -->
                    @if ($hourly->count() > 0)
                        <div class="card mb-4 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">Hourly Paid ({{ $hourly->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-sm table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>S#</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Hours Worked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hourly as $value)
                                            <tr>
                                                <td>
                                                    {{ $value->EmployeeID }}
                                                    <input type="hidden" name="EmployeeID[]"
                                                        value="{{ $value->EmployeeID }}">
                                                    <input type="hidden" name="SalaryTypeID[]"
                                                        value="{{ $value->AllowanceListID }}">
                                                </td>
                                                <td>{{ $value->FullName }}</td>
                                                <td>{{ $value->JobTitleName }}</td>
                                                <td>
                                                    <select name="JobID[]" class="form-select form-select-sm">
                                                        @foreach ($job as $j)
                                                            <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="PerHour[]" step="0.5" min="0"
                                                        max="24" class="form-control form-control-sm"
                                                        style="width: 90px;" placeholder="Hours">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- ==================== 4. Per Day ==================== -->
                    @if ($perday->count() > 0)
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Per Day ({{ $perday->count() }} Employees)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-sm table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>S#</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Days Worked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perday as $value)
                                            <tr>
                                                <td>
                                                    {{ $value->EmployeeID }}
                                                    <input type="hidden" name="EmployeeID[]"
                                                        value="{{ $value->EmployeeID }}">
                                                    <input type="hidden" name="SalaryTypeID[]"
                                                        value="{{ $value->AllowanceListID }}">
                                                </td>
                                                <td>{{ $value->FullName }}</td>
                                                <td>{{ $value->JobTitleName }}</td>
                                                <td>
                                                    <select name="JobID[]" class="form-select form-select-sm">
                                                        @foreach ($job as $j)
                                                            <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="PerDay[]" step="0.5" min="0"
                                                        max="1" class="form-control form-control-sm"
                                                        style="width: 90px;" placeholder="e.g. 1 or 0.5">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save Attendance</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        // Restrict date to today or future
        document.getElementById("Date").min = new Date().toISOString().split('T')[0];
    </script>
@endsection
