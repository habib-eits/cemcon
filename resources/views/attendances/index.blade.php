@extends('tmp')

@section('title', 'Attendance')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row mb-3">
                    <div class="col-9">
                        <h4 class="mb-0">Attendance List</h4>
                    </div>
                    <div class="col-3 text-end">
                        <a href="{{ route('attendances.create') }}" class="btn btn-primary"> <i class="bx bx-plus"></i>Add</a>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="attendanceTable" class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>User</th>
                                                <th>Branch</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendances as $attendance)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attendance->date }}</td>
                                                    <td>{{ $attendance->time ?? '-' }}</td>
                                                    <td>{{ $attendance->user->FullName ?? 'N/A' }}</td>
                                                    <td>{{ $attendance->branch->BranchName ?? 'N/A' }}</td>
                                                    <td>
                                                        <!-- Delete Button -->
                                                        <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this attendance?')"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                Delete
                                                            </button>
                                                        </form>
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
        </div>
    </div>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        "paging": true,       // Enable pagination
        "searching": true,    // Enable search
        "ordering": true,     // Enable column sorting
        "info": true,         // Show info text
        "lengthChange": true  // Show entries dropdown
    });
});
</script>
@endsection

