@extends('tmp')
@section('title', 'Salary')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

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
                    <div class="row">
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
                                        <input type="number" class="form-control" name="office_hours_per_day"
                                            value="{{ $salary->office_hours_per_day }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label>Working Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="working_days"
                                            value="{{ $salary->working_days }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label>Basic Per Hour Rate  <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="basic_hourly_rate"
                                            value="{{ $salary->basic_hourly_rate }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label>Overtime Per Hour Rate  <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="overtime_hourly_rate"
                                            value="{{ $salary->overtime_hourly_rate }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($salaryTypes as $type)
                        <div class="col-md-12">
                            <div class="card-header bg-light fw-bold"> {{ $type['name'] }}</div>
                            <div class="card">
                                <div class="card-body">
                                    @if (count($type['employees']) < 1)
                                        <p class="text-center text-warning">No Employee</p>
                                    @else
                                        <table class="table table-sm table-bordered">
                                            <thead class="">
                                                <tr>
                                                    <th colspan="3"></th>
                                                    <th colspan="3" class="text-center">Basic</th>
                                                    <th colspan="3" class="text-center">Overtime</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 5%">S#</th>
                                                    <th style="width: 15%">Employee</th>
                                                    <th style="width: 10%">Designation</th>

                                                    <th style="width: 10%">Rate</th>
                                                    <th style="width: 10%">Worked Hrs</th>
                                                    <th style="width: 10%">Amount</th>

                                                    <th style="width: 10%">Rate</th>
                                                    <th style="width: 10%">Worked Hrs</th>
                                                    <th style="width: 10%">Amount</th>

                                                    <th style="width: 10%">Gross Pay</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($type['employees'] as $row)
                                                    <tr>
                                                        <input type="hidden" name="salary_type_id[]"value="{{ $row->SalaryTypeID }}">
                                                        <input type="hidden" name="employee_id[]" value="{{ $row->EmployeeID }}">
                                                        <td>{{ $row->EmployeeID }}</td>
                                                        <td>{{ $row->FirstName }}</td>
                                                        <td>{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>
                                                        
                                                        
                                                        {{-- basic --}}
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="basic_hourly_rate[]" value="{{ $row->basic_hourly_rate }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="worked_hours[]" value="{{ $row->worked_hours }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="basic_total[]" value="{{ $row->basic_total }}" readonly>
                                                        </td>
                                                       
                                                        {{-- overtime --}}
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="overtime_hourly_rate[]" value="{{ $row->overtime_hourly_rate }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="overtime_hours[]" value="{{ $row->overtime_hours }}" readonly>
                                                        </td>   
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="overtime_total[]" value="{{ $row->overtime_total }}" readonly>
                                                        </td> 
                                                        
                                                        {{-- gross --}}
                                                        <td>
                                                            <input type="number" class="form-control" step="0.01" 
                                                               name="gross_salary[]" value="{{ $row->gross_salary }}" readonly>
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

    

@endsection
