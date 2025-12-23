{{-- @if ($employees->count())
    <div class="card mb-4 border-primary">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 text-white"> Per Day ({{ $perday->count() }} Employees)</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-sm table-striped mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>S#</th>
                        <th>Employee</th>
                        <th>Designation</th>
                        <th>Project</th>
                        <th>Attendance</th>
                        <th>Days Worked</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $row)
                        <tr>
                            <td>
                                {{ $row->EmployeeID }}
                                <input type="hidden" name="EmployeeID[]" value="{{ $row->EmployeeID }}">
                                <input type="hidden" name="SalaryTypeID[]" value="{{ $row->AllowanceListID }}">
                            </td>
                            <td>{{ $row->FirstName }}</td>
                            <td>{{ $row->jobTitle->JobTitleName ?? '' }}</td>
                            <td>
                                <select name="JobID[]" class="form-select form-select-sm">
                                    @foreach ($jobs as $j)
                                        <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="Attendance[]" class="form-select form-select-sm" style="width: 80px;">
                                    <option value="1">P</option>
                                    <option value="0">A</option>
                                    <option value="0.5">Half</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="days[]" step="0.5" max="1" class="form-control">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif --}}
@if ($perday->count())
    <div class="card mb-4 border-primary">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 text-white">Per Day ({{ $perday->count() }} Employees)</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-sm table-striped mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>S#</th>
                        <th>Employee</th>
                        <th>Designation</th>
                        <th>Project</th>
                        <th>Attendance</th>
                        <th>Days Worked</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perday as $row)
                        <tr>
                            <td>
                                {{ $row->EmployeeID }}
                                <input type="hidden" name="EmployeeID[]" value="{{ $row->EmployeeID }}">
                                <input type="hidden" name="SalaryTypeID[]" value="{{ $row->SalaryTypeID }}">
                            </td>
                            <td>{{ $row->FirstName }}</td>
                            <td>{{ $row->jobTitle->JobTitleName ?? '' }}</td>
                            <td>
                                <select name="JobID[]" class="form-select form-select-sm">
                                    <option value="">-- Select Project --</option>
                                    @foreach ($jobs as $j)
                                        <option value="{{ $j->JobID }}"
                                            {{ ($details[$row->EmployeeID]->job_id ?? null) == $j->JobID ? 'selected' : '' }}>
                                            {{ $j->JobNo }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="Attendance[]" class="form-select form-select-sm" style="width: 80px;">
                                    <option value="1"
                                        {{ ($details[$row->EmployeeID]->status ?? '1') == '1' ? 'selected' : '' }}>P
                                    </option>
                                    <option value="0"
                                        {{ ($details[$row->EmployeeID]->status ?? '1') == '0' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="0.5"
                                        {{ ($details[$row->EmployeeID]->status ?? '1') == '0.5' ? 'selected' : '' }}>
                                        Half</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.5" max="1" name="days[]" class="form-control"
                                    value="{{ $details[$row->EmployeeID]->days ?? 1 }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
