@extends('tmp')
@section('title', 'Attendance')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

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
                                                <th class="text-end" style="width: 10%">Status</th>
                                                <th class="text-end" style="width: 10%">Worked Hrs</th>
                                                <th class="text-end" style="width: 10%">OT</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($type['employees'] as $row)
                                                @php
                                                   [$class, $status] = match($row->status){
                                                    '1' => ['','P'],
                                                    '0.5' => ['text-warning','H'],
                                                    default => ['text-danger', 'A']
                                                   };


                                                @endphp
                                                <tr class="{{$class}}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $row->employee->FirstName }}</td>
                                                    <td>{{ $row->employee->jobTitle->JobTitleName ?? 'N/A' }}</td>
                                                    <td>{{ $row->job->JobNo ?? 'N/A' }}</td>
                                                    <td class="text-end">{{ $status }}</td>
                                                    <td class="text-end">{{ $row->worked_hours }}</td>
                                                    <td class="text-end">{{ $row->overtime }}</td>
                                                    <td class="text-end">
                                                        <button
                                                            class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $row->id }}">
                                                            Edit
                                                        </button>
                                                        
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
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="row_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1">Present</option>
                                <option value="0.5">Half Day</option>
                                <option value="0">Absent</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                             <select name="job_id" id="job_id" class="form-select">
                                @foreach ($jobs as $j)
                                    <option value="{{ $j->JobID }}">
                                        {{ $j->JobNo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Worked Hours</label>
                            <input type="number" step="0.01" class="form-control" name="worked_hours" id="worked_hours">
                        </div>

                        <div class="mb-3">
                            <label>Overtime</label>
                            <input type="number" step="0.01" class="form-control" name="overtime" id="overtime">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success update-btn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>






<script>


    $(document).ready(function () {
        $('.editBtn').on('click', function () {

            let id = $(this).data('id');

            $.ajax({
                url : "{{ route('attendance-details.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function (response) {

                    $('#row_id').val(response.id);
                    $('#worked_hours').val(response.worked_hours);
                    $('#overtime').val(response.overtime);

                    $('#status').select2({dropdownParent: $('#editModal'),width: '100%'}).val(response.status).trigger('change');

                    $('#job_id').select2({dropdownParent: $('#editModal'),width: '100%'}).val(response.job_id).trigger('change');

                    $('#editModal').modal('show');
                },
                error: function () {
                    alert('Unable to fetch data');
                }
            });
        });
    });

   $(document).ready(function () {
     $('#editForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#row_id').val(); // the row id from hidden input

        $.ajax({
            type: 'POST',
            url: "{{ route('attendance-details.update', ':id') }}".replace(':id', id),
            data:  new FormData(this),
            dataType: 'json',
            processData: false,
            contentType: false,

            success: function(response) {
                
                // console.log(response);
                $('#editModal').modal('hide');
                
                notyf.success({ message: response.message, duration: 3000 });
               
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
                alert('Update failed!');
            },
            complete: function() {
                // Hide spinner and enable button
                $('#spinner').hide();
                $('#editSubmitBtn').prop('disabled', false);
            }
        });
    });
   });



</script>


  
@endsection
