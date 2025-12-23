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
                        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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

                            @include('attendances.partials.fixed', ['employees' => $fixed])
                            @include('attendances.partials.fixed_ot', ['employees' => $fixed_ot])
                            @include('attendances.partials.hourly', ['employees' => $hourly])
                            @include('attendances.partials.perday', ['employees' => $perday])

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-content-save me-1"></i> Save Attendance
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('change', '.row-status', function() {
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
