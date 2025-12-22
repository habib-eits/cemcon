<div class="card">
    <div class="card-body">
        <ul class="list-unstyled categories-list">
            <li>
                <a href="{{ URL('/EmployeeDetail') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-speedometer-slow font-size-16 text-muted me-2"></i> <span
                        class="me-auto">Dashboard</span>
                </a>
            </li>



            <li>
                <a href="{{ URL('/EmployeeDocuments') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-folder font-size-16 text-warning me-2"></i> <span
                        class="me-auto">Documents</span>
                </a>
            </li>
            <li>
                <a href="{{ URL('/EmployeeSalary') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-bank font-size-16 text-muted me-2"></i> <span
                        class="me-auto">Salary</span>
                </a>
            </li>

            <li>
                <a href="{{ URL('/EmployeeLoan') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-account-cash font-size-20 text-muted me-2"></i> <span
                        class="me-auto">Advance / Loan</span>
                </a>
            </li>

            <li>
                <a href="{{ URL('/EmployeeLetters') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-file-document font-size-18 me-2 text-muted "></i> <span
                        class="me-auto">Letter</span>
                </a>
            </li>
            <li>
                <a href="{{ URL('/Leave') }}" class="text-body d-flex align-items-center">
                    <i class="mdi mdi-calendar-cursor
                        font-size-16 me-2"></i> <span
                        class="me-auto">Leave</span> <i
                        class="mdi mdi-circle-medium text-danger ms-2"></i>
                </a>
            </li>
            <li>
                <a href="{{ URL('/EmployeeLeaveReport') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-calendar-cursor
                        font-size-16 me-2"></i> <span
                        class="me-auto">Leave Report</span>
                </a>
            </li>
            <li>
                <a href="{{ URL('/EmployeeAttendance') }}"
                    class="text-body d-flex align-items-center">
                    <i class="mdi mdi-fingerprint
                        text-muted font-size-18 me-2"></i> <span
                        class="me-auto">Attendance</span>
                </a>
            </li>
            <li>
                <a href="{{ URL('/EmployeeWarningLeter') }}"
                    class="text-body d-flex align-items-center">
                    <i class="bx bxs-error-circle

                        text-muted font-size-18 me-2"></i> <span
                        class="me-auto">Warnings</span>
                </a>
            </li>

            <li>
                <a href="{{ URL('/EmployeeTeam') }}"
                    class="text-body d-flex align-items-center">
                    <i
                        class="mdi mdi-account-supervisor-circle
                        font-size-18 text-muted me-2"></i>
                    <span class="me-auto">Supervising</span>
                </a>
            </li>

            <li>
                <a href="{{ URL('/SalarySlip') }}" class="text-body d-flex align-items-center">
                    <i
                        class="mdi mdi-account-supervisor-circle
                        font-size-18 text-muted me-2"></i>
                    <span class="me-auto">Salary Slip</span>
                </a>
            </li>
            
        </ul>
    </div>
</div>