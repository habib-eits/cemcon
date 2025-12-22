<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="me-3">
                        @if ($employee->Picture)
                            <img src="{{ asset('emp-picture/' . $employee->Picture) }}" alt="Employee Photo"
                                class="avatar-md rounded">
                        @else
                            <img src="{{ asset('assets/images/users/avatar.png') }}" alt="Default Avatar"
                                class="avatar-md rounded">
                        @endif
                    </div>

                    <div class="media-body align-self-center">
                        <div class="text-muted">
                            <h5 class="mb-1">
                                {{ $employee->Title }} {{ $employee->FirstName }}
                                {{ $employee->MiddleName ? $employee->MiddleName : '' }}
                                {{ $employee->LastName }}
                            </h5>
                            <p class="mb-1">
                                {{ $employee->JobTitleName }} ,
                                {{ $employee->DepartmentName }}
                                <span class="badge badge-soft-success font-size-11 ms-2">
                                    {{ $employee->StaffType }}
                                </span>
                            </p>
                            <p class="mb-0">{{ $employee->BranchName }}</p>
                        </div>
                    </div>

                    <!-- Direct Edit Button/Icon -->
                    <div class="ms-auto">
                        <a href="{{ route('employees.edit', $employee->EmployeeID) }}"
                            class="btn btn-sm btn-outline-primary" title="Edit Employee">
                            <i class="mdi mdi-pencil font-size-18"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
