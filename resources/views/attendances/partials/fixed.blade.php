 <table class="table table-sm">
    <thead class="">
        <tr>
            <th style="width: 5%">S#</th>
            <th style="width: 15%">Employee</th>
            <th style="width: 10%">Designation</th>
            <th style="width: 30%">Project</th>
            <th style="width: 10%">Status</th>
            <th style="width: 10%">Office Hrs</th>
            <th style="width: 10%">Worked Hrs</th>
            <th style="width: 10%">OT</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fixed as $row)
            <tr>
                <input type="hidden" name="salary_type_id[]" value="{{ $row->SalaryTypeID }}">
                <input type="hidden" name="employee_id[]" value="{{ $row->EmployeeID }}">
                <td>
                    {{ $row->EmployeeID }}
                </td>
                <td>{{ $row->FirstName }}</td>
                <td>{{ $row->jobTitle->JobTitleName ?? 'N/A' }}</td>
                <td>
                    <select name="job_id[]" class="form-select select2">
                        @foreach ($jobs as $j)
                            <option value="{{ $j->JobID }}">{{ $j->JobNo }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="status[]" class="form-select row-status">
                        <option value="1">P</option>
                        <option value="0">A</option>
                        <option value="0.5">Half</option>
                    </select>
                </td>
                
                <td>
                    <input type="number" name="office_hours[]" class="form-control" step="0.01" value="{{ $attendance->office_hours  }}" readonly>
                </td>
                <td>
                    <input type="number" name="worked_hours[]" class="form-control" step="0.01" value="{{ $attendance->office_hours }}">
                </td>
                <td>
                    <input type="number" name="over_time[]" class="form-control" step="0.01">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>