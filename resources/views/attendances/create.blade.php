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
                        <form action="{{ route('attendances.store') }}" method="POST">
                            @csrf

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Branch <span
                                            class="text-danger">*</span></label>
                                    <select name="branch_id" class="form-select">
                                        <option value="">Select</option>
                                        @foreach ($branches as $value)
                                            <option value="{{ $value->BranchID }}"
                                                {{ old('branch_id') == $value->BranchID ? 'selected' : '' }}>
                                                {{ $value->BranchName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="basicpill-firstname-input">Date  <span
                                        class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="{{ old('date',date('Y-m-d')) }}">
                                </div>
                            </div>
                           

                            <button type="submit" class="btn btn-success">Submit</button>


                        </form>
                    </div>

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
                    @foreach ($fixed as $row)
                        <tr>
                            <td>
                                {{ $row->EmployeeID }}
                                <input type="hidden" name="EmployeeID[]" value="{{ $row->EmployeeID }}">
                            </td>
                            <td>{{ $row->FirstName .' - '. $row->lastName}}</td>
                            <td>{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>
                            <td>
                                <select name="JobID[]" class="form-select form-select-sm">
                                    @foreach ($jobs as $j)
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
        </div>
    </div>