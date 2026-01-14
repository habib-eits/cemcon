@extends('salary')
@section('title', 'Salary Sheet')
@section('content')
<style>
        /* Column group 1 */
        .col-group-1 {
    background-color: #fde2e2 !important;
}
.col-group-2 {
    background-color: #e2f0fd !important;
}
.col-group-3 {
    background-color: #e2fde2 !important;
}
.col-group-4 {
    background-color: #fff9e2 !important;
}
.col-group-5 {
    background-color: #f2e2fd !important;
}


        input[type="number"]:not(.no-style) {
            text-align: right;
            padding: 0px 2px 0px 0px;
            border-radius: 0;
        }

        input[type="number"][readonly]:not(.no-style) {
            border: none;
            background: none;
        }
</style>
<div class="main-content">
    <div class="page-content mt-2">
        <div class="container-fluid">
            <h3>Salary Sheet Details</h3>

            <div class="row mb-3">
                <div class="col-md-2">
                    <strong>Branch:</strong> {{ $salary->branch->BranchName ?? '-' }}
                </div>
                <div class="col-md-2">
                    <strong>Date:</strong> {{ $salary->salary_month }}
                </div>
                <div class="col-md-2">
                    <strong>Office Hours:</strong> {{ $salary->office_hours_per_day }}
                </div>
                <div class="col-md-2">
                    <strong>Working Days:</strong> {{ $salary->working_days }}
                </div>
                <div class="col-md-2">
                    <strong>OT Working Days Rate:</strong> {{ $salary->overtime_working_day_rate }}
                </div>
                <div class="col-md-2">
                    <strong>OT Holiday Rate:</strong> {{ $salary->overtime_holiday_rate }}
                </div>
            </div>

            @foreach ($salaryTypes as $type)
                <div class="card mb-3">
                    <div class="card-header bg-light fw-bold">{{ $type['name'] }}</div>
                    <div class="">
                        @if ($type['employees']->isEmpty())
                            <p class="text-center text-warning">No Employee</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="col-group-1"></th>
                                            <th colspan="3" class="col-group-2 text-center">Basic</th>
                                            <th colspan="3" class="col-group-3 text-center">OT Working Days</th>
                                            <th colspan="3" class="col-group-4 text-center">OT Holiday</th>
                                            <th colspan="3" class="col-group-5"></th>
                                        </tr>
                                        <tr>
                                            <th class="col-group-1" style="width: 4%">S#</th>
                                            <th class="col-group-1" style="width: 14%">Employee</th>
                                            <th class="col-group-1" style="width: 6%">Salary</th>
                                            <th class="col-group-1" style="width: 10%">Designation</th>

                                            <th class="col-group-2" style="width: 6%">Rate</th>
                                            <th class="col-group-2" style="width: 4%">Hrs</th>
                                            <th class="col-group-2" style="width: 6%">Amount</th>

                                            <th class="col-group-3" style="width: 6%">Rate</th>
                                            <th class="col-group-3" style="width: 4%">Hrs</th>
                                            <th class="col-group-3" style="width: 6%">Amount</th>

                                            <th class="col-group-4" style="width: 6%">Rate</th>
                                            <th class="col-group-4" style="width: 4%">Hrs</th>
                                            <th class="col-group-4" style="width: 6%">Amount</th>

                                            <th class="col-group-5" style="width: 6%">Gross</th>
                                            <th class="col-group-5" style="width: 5%">Adv</th>
                                            <th class="col-group-5" style="width: 7%">Net</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($type['employees'] as $row)
                                        <tr>
                                            <td class="col-group-1">{{ $loop->iteration }}</td>
                                            <td class="col-group-1">{{ $row->employee->FirstName ?? 'N/A' }}</td>
                                            <td class="col-group-1">{{ $row->salary_base_amount }}</td>
                                            <td class="col-group-1">{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>

                                            {{-- Basic --}}
                                            <td class="col-group-2 text-end">{{ $row->basic_hourly_rate }}</td>
                                            <td class="col-group-2 text-end">{{ $row->basic_worked_hours }}</td>
                                            <td class="col-group-2 text-end">{{ $row->basic_total }}</td>

                                            {{-- OT --}}
                                            <td class="col-group-3 text-end">{{ $row->overtime_hourly_rate }}</td>
                                            <td class="col-group-3 text-end">{{ $row->overtime_hours }}</td>
                                            <td class="col-group-3 text-end">{{ $row->overtime_total }}</td>

                                            {{-- Holiday OT --}}
                                            <td class="col-group-4 text-end">{{ $row->holiday_overtime_hourly_rate }}</td>
                                            <td class="col-group-4 text-end">{{ $row->holiday_overtime_hours }}</td>
                                            <td class="col-group-4 text-end">{{ $row->holiday_overtime_total }}</td>

                                            {{-- Totals --}}
                                            <td class="col-group-5 text-end">{{ $row->gross_salary }}</td>
                                            <td class="col-group-5 text-end">{{ $row->advance_paid }}</td>
                                            <td class="col-group-5 text-end">{{ $row->net_salary }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

@endsection
