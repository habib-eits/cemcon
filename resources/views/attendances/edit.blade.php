@extends('tmp')
@section('title', 'Attendance')
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
                <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            value="{{ $attendance->branch->BranchName }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date"
                                            value="{{ $attendance->date }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Office Hours <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="office_hours"
                                            value="{{ $attendance->office_hours }}" readonly>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($type['employees'] as $row)
                                                    <tr>
                                                        <input type="hidden" name="salary_type_id[]"
                                                            value="{{ $row->SalaryTypeID }}">
                                                        <input type="hidden" name="employee_id[]"
                                                            value="{{ $row->EmployeeID }}">
                                                        <td>
                                                            {{ $row->EmployeeID }}
                                                        </td>
                                                        <td>{{ $row->FirstName }}</td>
                                                        <td>{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>
                                                        <td>
                                                            <select name="job_id[]" class="form-select select2">
                                                                @foreach ($jobs as $j)
                                                                    <option value="{{ $j->JobID }}">
                                                                        {{ $j->JobNo }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="status[]" class="form-select row-status">
                                                                <option value="1">P</option>
                                                                <option value="0">A</option>
                                                                <option value="0.5">Half</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number" name="office_hours[]"
                                                                class="form-control row-office-hours" step="0.01"
                                                                value="{{ $attendance->office_hours }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="worked_hours[]"
                                                                class="form-control row-worked-hours toggle-readonly"
                                                                step="0.01" value="{{ $attendance->office_hours }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="over_time[]"
                                                                class="form-control row-over-time toggle-readonly"
                                                                step="0.01" value="0">
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
        $(document).on('change', '.row-status', function() {
            let row = $(this).closest('tr');
            row.find('.toggle-readonly').prop('readonly', false);
            row.find('.toggle-readonly').removeClass('d-none');

            let officeHours = row.find('.row-office-hours').val();
            row.find('.row-worked-hours').val(officeHours);

            row.removeClass();

            let status = Number($(this).val());

            switch (status) {
                case 1:
                    row.removeClass();
                    
                    break;
                case 0:
                    row.addClass('bg-danger');
                    row.find('.toggle-readonly').val(0);
                    row.find('.toggle-readonly').prop('readonly', true);
                    row.find('.toggle-readonly').addClass('d-none');
                    break;
                case 0.5:
                    row.addClass('bg-warning');
                    row.find('.toggle-readonly').val(0);

                    break;
                default:
                    row.removeClass();
            }
        });
    </script>

@endsection
