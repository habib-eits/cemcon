{{-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <input type="text" class="form-control" id="employeeName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1">Present</option>
                            <option value="0">Absent</option>
                            <option value="0.5">Half Day</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="job_id" id="job_id" class="form-select">
                            <option value="">Select Project</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->JobID }}">{{ $job->JobNo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Worked Hours</label>
                        <input type="number" step="0.25" name="worked_hours" id="worked_hours" class="form-control"
                            value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Overtime (OT)</label>
                        <input type="number" step="0.25" name="over_time" id="over_time" class="form-control"
                            value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<!-- Attendance Detail Edit Modal -->
<div class="modal fade" id="attendanceEditModal" tabindex="-1" role="dialog"
    aria-labelledby="attendanceEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="attendanceEditModalLabel">Edit Attendance Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="attendanceEditForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <!-- Employee -->
                    <div class="row">
                        <div class="col-12">
                            <label><strong>Employee</strong></label>
                            <input type="text" class="form-control" id="employeeName" readonly>
                            <input type="hidden" name="employee_id" id="employee_id">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <label><strong>Status *</strong></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="1">Present</option>
                                <option value="0">Absent</option>
                                <option value="0.5">Half Day</option>
                            </select>
                        </div>
                    </div>

                    <!-- Project -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <label><strong>Project *</strong></label>
                            <select name="job_id" id="job_id"
                                class="form-select select2"
                                style="width:100%" required>
                                <option value="">-- Select Project --</option>
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->JobID }}">{{ $job->JobNo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Worked Hours -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <label><strong>Worked Hours</strong></label>
                            <input type="number" step="0.25" name="worked_hours"
                                id="worked_hours" class="form-control">
                        </div>
                    </div>

                    <!-- Overtime -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <label><strong>Overtime (OT)</strong></label>
                            <input type="number" step="0.25" name="over_time"
                                id="over_time" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>
