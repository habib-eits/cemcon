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
                            <h4 class="mb-sm-0 font-size-18">Attendance Create</h4>
                            <a href="{{ URL('/Attendance') }}" class="btn btn-success btn-rounded">
                                <i class="mdi mdi-arrow-left me-1"></i> Go Back
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Alerts --}}
                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }}">
                        <strong>{{ Session::get('error') }}</strong>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ URL('/AttendanceSave') }}" method="post">
                    {{ csrf_field() }}

                    {{-- Date --}}
                    <div class="col-md-4 mb-3">
                        <label>Date*</label>
                        <input type="date" class="form-control form-control-sm" name="Date"
                            value="{{ date('Y-m-d') }}" style="width:130px;">
                    </div>

                    @php
                        $salaryTypes = [
                            1 => 'Fixed Salary',
                            2 => 'Fixed + Overtime',
                            3 => 'Hourly Based',
                            4 => 'Daily Based',
                        ];
                    @endphp

                    @foreach ($salaryTypes as $typeId => $typeTitle)
                        @php
                            $employees = $employee->where('AllowanceListID', $typeId);
                        @endphp

                        @if ($employees->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <strong>Salary Type {{ $typeId }} - {{ $typeTitle }}</strong>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>S#</th>
                                                <th>Employee</th>
                                                <th>Designation</th>
                                                <th>Salary Type</th>
                                                <th>Project</th>
                                                <th>Attendance</th>
                                                <th>OT</th>
                                                <th>Per Hour</th>
                                                <th>Per Day</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $value)
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
                                                    <td>{{ $value->AllowanceTitle }}</td>

                                                    <td>
                                                        <select name="JobID[]" class="form-select select2">
                                                            @foreach ($job as $j)
                                                                <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        @if (in_array($typeId, [1, 2, 4]))
                                                            <select name="Attendance[]" style="width:65px">
                                                                <option value="1">P</option>
                                                                <option value="0">A</option>
                                                                <option value="0.5">Half</option>
                                                            </select>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($typeId == 2)
                                                            <input type="number" name="OT[]" style="width:65px" placeholder="overtime">
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($typeId == 3)
                                                            <input type="number" name="PerHour[]" style="width:65px" placeholder="Hour">
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($typeId == 4)
                                                            <input type="number" name="PerDay[]" style="width:65px" placeholder="Day">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <button type="submit" class="btn btn-success w-sm float-end">
                        Save Attendance
                    </button>

                </form>

            </div>
        </div>
    </div>

@endsection
