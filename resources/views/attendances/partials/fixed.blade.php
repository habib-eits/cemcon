<!-- ==================== 1. Fixed Salary ==================== -->
@if ($fixed->count() > 0)
    <div class="card mb-4 border-primary">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 text-white">Fixed Salary ({{ $fixed->count() }} Employees)</h5>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fixed as $value)
                        <tr>
                            <td>
                                {{ $value->EmployeeID }}
                                <input type="hidden" name="EmployeeID[]" value="{{ $value->EmployeeID }}">
                                <input type="hidden" name="SalaryTypeID[]" value="{{ $value->SalaryTypeID }}">
                            </td>
                            <td>{{ $value->FirstName }}</td>
                            <td>{{ $value->jobTitle->JobTitleName ?? '' }}</td>
                            <td>
                                <select name="JobID[]" class="form-select form-select-sm">
                                    <option value="">-- Select Project --</option>
                                    @foreach ($jobs as $j)
                                        <option value="{{ $j->JobID }}"
                                            {{ ($details[$value->EmployeeID]->job_id ?? null) == $j->JobID ? 'selected' : '' }}>
                                            {{ $j->JobNo }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="Attendance[]" class="form-select form-select-sm" style="width: 80px;">
                                    <option value="1"
                                        {{ ($details[$value->EmployeeID]->status ?? '1') == '1' ? 'selected' : '' }}>P
                                    </option>
                                    <option value="0"
                                        {{ ($details[$value->EmployeeID]->status ?? '1') == '0' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="0.5"
                                        {{ ($details[$value->EmployeeID]->status ?? '1') == '0.5' ? 'selected' : '' }}>
                                        Half</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
