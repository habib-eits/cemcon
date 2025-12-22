 <div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">

            {{-- Employee Avatar --}}
            <div class="me-3">
                <img src="{{ $employee->Picture ? asset('emp-picture/' . $employee->Picture) : asset('assets/images/users/avatar.png') }}"
                    alt="Employee Avatar" class="avatar-md rounded">
            </div>

            {{-- Employee Info --}}
            <div class="flex-grow-1">
                <div class="text-muted">
                    <h5 class="mb-1">
                        {{ $employee->Title }}
                        {{ $employee->FullName }}
                        {{ $employee->MiddleName }}
                        {{ $employee->LastName }}
                    </h5>

                    <p class="mb-1">
                        {{ $employee->JobTitleName }},
                        {{ $employee->DepartmentName }}

                        <span class="badge bg-success ms-2">
                            {{ $employee->StaffType }}
                        </span>
                    </p>

                    <p class="mb-0">
                        {{ $employee->BranchName }}
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="dropdown ms-2">
                <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bxs-cog me-1"></i> Manage
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item"
                            href="{{ url('EmployeeEdit/' . $employee->EmployeeID) }}">
                            <i class="mdi mdi-pencil me-2"></i> Edit
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#">
                            <i class="mdi mdi-trash-can me-2"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>