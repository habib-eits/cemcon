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
                <div class="row"> 
                    <div class="col-12">
                        <form action="" method="POST">
                            @csrf

                             <div class="row align-items-end">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $attendance->branch->BranchName }}" readonly>
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
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead class="">
                                    <tr>
                                        <th style="width: 5%">S#</th>
                                        <th style="width: 15%">Employee</th>
                                        <th style="width: 15%">Designation</th>
                                        <th style="width: 30%">Project</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 5%">Worked Hrs</th>
                                        <th style="width: 5%">OT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fixed as $row)
                                        <tr>
                                            <td>
                                                {{ $row->EmployeeID }}
                                                <input type="hidden" name="employee_id[]" value="{{ $row->EmployeeID }}">
                                            </td>
                                            <td>{{ $row->FirstName }}</td>
                                            <td>{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>
                                            <td>
                                                <select name="job_id[]" class="form-select select2">
                                                    @foreach ($jobs as $j)
                                                        <option value="{{ $j->JobID }}">{{ $j->JobNo }}
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
                                                <input type="number" class="form-control" step="0.01" value="{{ $attendance->office_hours  }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" step="0.01">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('change', '.row-status', function () {
            let row = $(this).closest('tr');

            // Remove ALL classes
            row.removeClass();

            let status = Number($(this).val());

            switch (status) {
                case 1:
                    row.removeClass();
                    break;
                case 0:
                    row.addClass('bg-danger');
                    break;
                case 0.5:
                    row.addClass('bg-warning');
                    break;
                default:
                     row.removeClass();
            }
        });

    </script>

 @endsection   