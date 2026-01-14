@extends('salary')
@section('title', 'Salary')
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
                <h3>Salary Sheet</h3>
                <!-- start page title -->
                @if (count($errors) > 0)
                    <div>
                        <div class="alert alert-danger pt-3 pl-0   border-3 bg-danger text-white">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="salary_id" value="{{ $salary->id }}">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row align-items-end">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>Branch <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $salary->branch->BranchName }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="salary_peroid"
                                                    value="{{ $salary->salary_month }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>Office Hours <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control no-style"
                                                    name="office_hours_per_day" value="{{ $salary->office_hours_per_day }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>Working Days <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control no-style" name="working_days"
                                                    value="{{ $salary->working_days }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>OT Working Days Rate <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control no-style"
                                                    name="overtime_working_day_rate"
                                                    value="{{ $salary->overtime_working_day_rate }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label>OT Holiday Rate <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control no-style"
                                                    name="overtime_holiday_rate"
                                                    value="{{ $salary->overtime_holiday_rate }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($salaryTypes as $type)
                        <div class="col-md-12">
                            <div class="card-header bg-light fw-bold"> {{ $type['name'] }}</div>
                            <div class="card">
                                <div class="">
                                    @if (count($type['employees']) < 1)
                                        <p class="text-center text-warning">No Employee</p>
                                    @else
                                        <table class="table table-sm table-bordered">
                                            <thead class="">
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
                                                        <input type="hidden"name="salary_id[]" value="{{ $row->salary_id }}">
                                                        <input type="hidden"name="salary_type_id[]" value="{{ $row->SalaryTypeID }}">
                                                        <input type="hidden"name="employee_id[]" value="{{ $row->EmployeeID }}">
                                                        <input type="hidden"name="job_title_id[]" value="{{ $row->JobTitleID }}">
                                                        <input type="hidden" step="0.01" name="salary_base_amount[]" value="{{ $row->salary_base_amount }}">
                                                        <input type="hidden"  step="0.01" name="salary_base_per_day[]" value="{{ $row->salary_base_per_day }}">

                                                        <td class="col-group-1">{{ $row->EmployeeID }}</td>
                                                        <td class="col-group-1">{{ $row->FirstName }}</td>
                                                        <td class="col-group-1">{{ $row->Salary != null ? $row->Salary : '-' }}</td>
                                                        <td class="col-group-1">{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>


                                                        {{-- basic --}}
                                                    
                                                        <td class="col-group-2">
                                                            <input type="number" class="form-control" step="0.000001"
                                                                name="basic_hourly_rate[]"
                                                                value="{{ $row->basic_hourly_rate }}" readonly>
                                                        </td>
                                                        <td class="col-group-2">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="basic_worked_hours[]"
                                                                value="{{ $row->basic_worked_hours }}" readonly>
                                                        </td>
                                                        <td class="col-group-2">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="basic_total[]" value="{{ $row->basic_total }}"
                                                                readonly>
                                                        </td>
                                                           

                                                        {{-- overtime --}}
                                                       
                                                        <td class="col-group-3">
                                                            <input type="number" class="form-control" step="0.000001"
                                                                name="overtime_hourly_rate[]"
                                                                value="{{ $row->overtime_hourly_rate }}" readonly>
                                                        </td>
                                                        <td class="col-group-3">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="overtime_hours[]"
                                                                value="{{ $row->overtime_hours }}" readonly>
                                                        </td>
                                                        <td class="col-group-3">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="overtime_total[]"
                                                                value="{{ $row->overtime_total }}" readonly>
                                                        </td>
                                                        

                                                        {{-- Holiday overtime --}}
                                                         
                                                        <td class="col-group-4">
                                                            <input type="number" class="form-control" step="0.000001"
                                                                name="holiday_overtime_hourly_rate[]"
                                                                value="{{ $row->holiday_overtime_hourly_rate }}" readonly>
                                                        </td>
                                                        <td class="col-group-4">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="holiday_overtime_hours[]"
                                                                value="{{ $row->holiday_overtime_hours }}" readonly>
                                                        </td>
                                                        <td class="col-group-4">
                                                            <input type="number" class="form-control" step="0.01"
                                                                name="holiday_overtime_total[]"
                                                                value="{{ $row->holiday_overtime_total }}" readonly>
                                                        </td>
                                                        

                                                        {{-- gross --}}
                                                        <td class="col-group-5">
                                                            <input type="number" class="form-control row-gross-salary" step="0.01"
                                                                name="gross_salary[]" value="{{ $row->gross_salary }}"
                                                                readonly>
                                                        </td>
                                                        {{-- Adv --}}
                                                        <td class="col-group-5">
                                                            <input type="number" class="form-control row-advance-paid" step="0.01"
                                                                name="advance_paid[]" value="{{ $row->advance_paid }}">
                                                        </td>
                                                        {{-- Net --}}
                                                        <td class="col-group-5">
                                                            <input type="number" class="form-control row-net-salary fw-bold" step="0.01"
                                                                name="net_salary[]" value="{{ $row->net_salary }}" readonly>
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

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>



            </div>
        </div>
    </div>

<script>
$(document).on('input', '.row-advance-paid', function () {
    let row = $(this).closest('tr');

    let gross = parseFloat(row.find('.row-gross-salary').val()) || 0;
    let advance = parseFloat($(this).val()) || 0;

    let net = gross - advance;

    row.find('.row-net-salary').val(net.toFixed(2));
});
</script>


@endsection
