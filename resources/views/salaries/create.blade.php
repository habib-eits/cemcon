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
                <div class="row">
                    <div class="col-4">
                        <form action="{{ route('salaries.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
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
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="salary_period">Month Year <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="salary_period" id="salary_period"
                                            value="{{ old('salary_period', date('Y-m-d')) }}">
                                    </div>
                                </div>

                                <!-- Total Days in Month -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="month_days">Total Days in Month <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="month_days" id="month_days"
                                            value="{{ old('month_days', date('t')) }}" readonly>
                                    </div>
                                </div>
                                <!-- Working Days -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="working_days">Working Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="working_days" id="working_days"
                                            value="{{ old('working_days', 22) }}">
                                    </div>
                                </div>

                                <!-- Office Hours -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="office_hours">Office Hours <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" name="office_hours"
                                            id="office_hours" value="{{ old('office_hours', 8) }}">
                                    </div>
                                </div>

                                <!-- Overtime Per Hour -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="overtime_per_hour">Overtime Per Hour <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" name="overtime_per_hour"
                                            id="overtime_per_hour" value="{{ old('overtime_per_hour', 0) }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Salary</button>


                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#salary_period').on('change', function() {
                let monthValue = $(this).val(); // Format: YYYY-MM
                if(monthValue) {
                    let parts = monthValue.split('-');
                    let year = parseInt(parts[0]);
                    let month = parseInt(parts[1]);

                    // Calculate total days in the month
                    let totalDays = new Date(year, month, 0).getDate();

                    // Set the value of month_days input
                    $('#month_days').val(totalDays);
                }
            });
        });
</script>
@endsection
