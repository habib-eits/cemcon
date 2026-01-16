@extends('tmp')

@section('title', 'Attendance Sheet')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">


                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('attendances.sheet') }}">
                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <label>Start Date</label>
                                    <input type="date" name="startDate" class="form-control"
                                        value="{{ request('startDate', $startDate) }}">
                                </div>

                                <div class="col-md-3">
                                    <label>End Date</label>
                                    <input type="date" name="endDate" class="form-control"
                                        value="{{ request('endDate', $endDate) }}">
                                </div>

                                <div class="col-md-3">
                                    <label>Branch</label>
                                    <select name="branch_id" class="form-control">
                                        <option value="">All Branches</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->BranchID }}"
                                                {{ request('branch_id') == $branch->BranchID ? 'selected' : '' }}>
                                                {{ $branch->BranchName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Search
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>




                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Branch</th>
                                    @foreach ($dates as $date)
                                        <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($attendanceDetails as $employeeAttendances)
                                    @php
                                        $employee = $employeeAttendances->first()->employee;
                                        $attendanceByDate = $employeeAttendances->keyBy('date');
                                    @endphp

                                    <tr>
                                        <td>{{ $employee->FirstName . ' ' . $employee->MiddleName . ' ' . $employee->LastName }}
                                        </td>
                                        <td>{{ $employee->branch->BranchName ?? '' }}</td>

                                        @foreach ($dates as $date)
                                            @php
                                                $status = $attendanceByDate->has($date)
                                                    ? $attendanceByDate[$date]->status
                                                    : null;
                                            @endphp

                                            <td align="left">
                                                @if ($status === '1')
                                                    <span class="text-success">P</span>
                                                @elseif ($status === '0.5')
                                                    <span class="text-warning">H</span>
                                                @elseif ($status === '0')
                                                    <span class="text-danger">A</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
