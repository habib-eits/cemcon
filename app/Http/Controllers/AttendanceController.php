<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\AttendanceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $employees =  Employee::with([
            'jobTitle',
            'supervisor',
            'department',
        ])
            ->where('StaffType', '<>', 'Inactive')
            ->orderBy('EmployeeID');

        return view('attendances.create', [
            'branches' =>  DB::table('branch')->get(),
            'jobs' =>  DB::table('job')->get(),
            'fixed' => $employees->where('SalaryTypeID', 1)->get(),
            'fixed_ot' => $employees->where('SalaryTypeID', 2)->get(),
            'hourly' => $employees->where('SalaryTypeID', 3)->get(),
            'perday' => $employees->where('SalaryTypeID', 4)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'date' => 'required',
    //         'branch_id' => 'required',
    //         'office_hours' => 'required|numeric',
    //     ]);

    //     $is_exists = Attendance::where([
    //         'branch_id' => $request->branch_id,
    //         'date' => $request->date,
    //     ])
    //         ->exists();

    //     if ($is_exists) {
    //         return back()->withErrors([
    //             'date' => 'Attendance already exists for this branch on this date.',
    //         ]);
    //     }

    //     $validated['user_id'] = Session::get('UserID') ?? null;

    //     $attendance =  Attendance::create($validated);

    //     return redirect()->route('attendances.edit', $attendance->id);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'branch_id' => 'required|exists:branch,BranchID',
            'office_hours' => 'required|integer|min:1',
        ]);

        $existingAttendance = Attendance::where('branch_id', $validated['branch_id'])
            ->where('date', $validated['date'])
            ->first();

        if ($existingAttendance) {
            return redirect()->route('attendances.edit', $existingAttendance->id)
                ->with('info', 'Attendance already exists for this date. You can edit it below.');
        }

        // Create new attendance header
        $attendance = Attendance::create([
            'date' => $validated['date'],
            'branch_id' => $validated['branch_id'],
            'office_hours' => $validated['office_hours'],
            'user_id' => Session::get('UserID') ?? null,
        ]);

        return redirect()->route('attendances.edit', $attendance->id)
            ->with('success', 'New attendance header created. Now mark employee attendance.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::find($id);


        $employees =  Employee::with([
            'jobTitle',
            'supervisor',
            'department',
        ])
            ->where('StaffType', '<>', 'Inactive')
            ->where('BranchID', $attendance->branch_id)
            ->orderBy('EmployeeID')
            ->get();

        // Load existing details (for pre-fill)
        $details = AttendanceDetail::where('attendance_id', $attendance->id)
            ->get()
            ->keyBy('employee_id');

        return view('attendances.edit', [
            'attendance' =>  $attendance,
            'branches' =>  DB::table('branch')->get(),
            'jobs' =>  DB::table('job')->get(),

            'fixed'     => $employees->where('SalaryTypeID', 1),
            'fixed_ot'  => $employees->where('SalaryTypeID', 2),
            'hourly'    => $employees->where('SalaryTypeID', 3),
            'perday'    => $employees->where('SalaryTypeID', 4),

            'details' => $details,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'EmployeeID' => 'required|array',
            'SalaryTypeID' => 'required|array',
            'JobID' => 'nullable|array',
            'Attendance' => 'required|array',
            'worked_hours' => 'nullable|array',
            'ot' => 'nullable|array',
        ]);

        // Delete old details
        $attendance->details()->delete();

        // Re-save updated details
        foreach ($validated['EmployeeID'] as $index => $employeeId) {
            if (empty($employeeId)) continue;

            $attendance->details()->create([
                'date' => $attendance->date,
                'employee_id' => $employeeId,
                'salary_type_id' => $validated['SalaryTypeID'][$index],
                'job_id' => $validated['JobID'][$index] ?? null,
                'status' => $validated['Attendance'][$index] ?? '1',
                'office_hours' => $attendance->office_hours,
                'worked_hours' => $validated['worked_hours'][$index] ?? 0,
                'over_time' => $validated['ot'][$index] ?? 0,
                'branch_id' => $attendance->branch_id,
            ]);
        }

        return redirect()->route('attendances.index')
            ->with('success', 'Employee attendance marked successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
