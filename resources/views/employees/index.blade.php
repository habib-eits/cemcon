@extends('template.tmp')
@section('title', 'Employee List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Employee List</h4>
                            <a href="{{ route('employees.create') }}"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                    class="mdi mdi-plus me-1"></i> New Employee</a>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if (Session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-3" id="success-alert">

                        {{ Session::get('error') }}
                    </div>
                @endif
                <div id="ajax-alert"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <table id="datatable" class="table table-hover  dt-responsive  nowrap w-100 table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Designation</th>
                                            <th>Salary Type</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>

        <!--- Delete modal---->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this employee?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('employees.index') }}",
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'FullName',
                            name: 'FullName'
                        },
                        {
                            data: 'JobTitleName',
                            name: 'JobTitleName'
                        },
                        {
                            data: 'SalaryTypeTitle',
                            name: 'SalaryTypeTitle'
                        },
                        {
                            data: 'StaffType',
                            name: 'StaffType'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>

        <script>
            let deleteId = null;

            function delete_confirm22(id) {
                deleteId = id;
                $('#deleteModal').modal('show');
            }

            $('#confirmDeleteBtn').on('click', function() {

                if (!deleteId) return;

                $.ajax({
                    url: "/employees/" + deleteId,
                    type: "POST",
                    data: {
                        _method: "DELETE",
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        $('#deleteModal').modal('hide');

                        $('#ajax-alert').html(`
                <div class="alert alert-success alert-dismissible fade show">
                    ${response.message ?? 'Employee deleted successfully'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);

                        $('#datatable').DataTable().ajax.reload(null, false);
                    },
                    error: function() {

                        $('#deleteModal').modal('hide');

                        $('#ajax-alert').html(`
                <div class="alert alert-danger alert-dismissible fade show">
                    Failed to delete employee
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
                    }
                });
            });
        </script>

        <script>
            function edit_data(id) {
                window.location.href = "{{ route('employees.edit', ':id') }}".replace(':id', id);
            }
        </script>


    @endsection