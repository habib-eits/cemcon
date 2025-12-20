@extends('template.tmp')
@section('title', 'HR')
@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Attendance</h4>
                            <div class="page-title-right">
                                <div class="page-title-right">
                                    <!-- button will appear here -->
                                    <a href="{{ route('attendances.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light  me-2"><i
                                            class="mdi mdi-plus me-1"></i> New Attendance</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xl-12">
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                        <script>
                            @if (Session::has('error'))
                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true
                                }
                                Command: toastr["success"]("{{ session('error') }}")
                            @endif
                        </script>

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

                        <div class="card">
                            <div class="card-body">
                                @if (count($attendance) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped  table-sm  m-0" id="student_table"
                                            data-page-length="25">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.No</th>
                                                    <th scope="col">Attendance Date</th>

                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach ($attendance as $value)
                                                    <tr>
                                                        <td>{{ $i }}.</td>
                                                        <td>{{ dateformatman($value->Date) }}</td>
                                                        <td>
                                                            <!-- View Button -->
                                                            <a href="{{ route('attendances.show', $value->Date) }}"
                                                                class="btn btn-sm btn-outline-info" title="View">
                                                                <i class="mdi mdi-eye-outline"></i>
                                                            </a>

                                                            <!-- Delete Button with Form -->
                                                            <form action="{{ route('attendances.destroy', $value->Date) }}"
                                                                method="POST" style="display: inline;"
                                                                onsubmit="return confirm('Are you sure you want to delete attendance for {{ dateformatman($value->Date) }}? This action cannot be undone.');">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger ms-1"
                                                                    title="Delete">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if (count($attendance) == 0)
                                    <p class="text-danger h6">No record to display</p>
                                @endif
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#student_table').DataTable();
            });
        </script>


        <script>
            $("#success-alert").fadeTo(4000, 500).slideUp(100, function() {
                // $("#success-alert").slideUp(500);
                $("#success-alert").alert('close');
            });
        </script>

    @endsection
