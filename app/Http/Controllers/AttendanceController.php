<?php

namespace App\Http\Controllers;

use App\Models\Job;
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'branch_id' => 'required',
            'office_hours' => 'required|numeric',
        ]);

        $is_exists = Attendance::where([
            'branch_id' => $request->branch_id,
            'date' => $request->date,
        ])
            ->exists();

        if ($is_exists) {
            return back()->withErrors([
                'date' => 'Attendance already exists for this branch on this date.',
            ]);
        }

        $validated['user_id'] = Session::get('UserID') ?? null;

        $attendance =  Attendance::create($validated);

        return redirect()->route('attendances.edit', $attendance->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance = Attendance::with('details', 'details.job')->find($id);

        // dd($attendance);
        $attendanceDetails = $attendance->details->groupBy('salary_type_id');
        // dd($attendanceDetails);

        // dd($attendanceDetails);
        $salaryTypes = [
            [
                'name' => 'Fixed Salary',
                'employees' => $attendanceDetails->get(1, collect())
            ],
            [
                'name' => 'Fixed Salary + Over Time',
                'employees' => $attendanceDetails->get(2, collect())
            ],
            [
                'name' => 'Hourly',
                'employees' => $attendanceDetails->get(3, collect())
            ],
            [
                'name' => 'Per Day',
                'employees' => $attendanceDetails->get(4, collect())
            ],
        ];

        $jobs = Job::all();

        return view('attendances.show', compact('salaryTypes', 'attendance', 'jobs'));
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

        $employees = Employee::with([
            'jobTitle',
            'supervisor',
            'department',
        ])
            ->where('StaffType', '<>', 'Inactive')
            ->where('BranchID', $attendance->branch_id)
            ->orderBy('EmployeeID')
            ->get();
        $employeesBySalary = $employees->groupBy('SalaryTypeID');

        $salaryTypes = [
            [
                'name' => 'Fixed Salary',
                'employees' => $employeesBySalary->get(1, collect())
            ],
            [
                'name' => 'Fixed Salary + Over Time',
                'employees' => $employeesBySalary->get(2, collect())
            ],
            [
                'name' => 'Hourly',
                'employees' => $employeesBySalary->get(3, collect())
            ],
            [
                'name' => 'Per Day',
                'employees' => $employeesBySalary->get(4, collect())
            ],
        ];



        return view('attendances.edit', [
            'attendance' =>  $attendance,
            'branches' =>  DB::table('branch')->get(),
            'jobs' =>  DB::table('job')->get(),
            'salaryTypes' => $salaryTypes
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

        $attendance = Attendance::find($id);

        for ($i = 0; $i < count($request->employee_id); $i++) {
            AttendanceDetail::create([
                'attendance_id' => $attendance->id,
                'date'          => $attendance->date,
                'office_hours'  => $attendance->office_hours,
                'branch_id'     => $attendance->branch_id,

                'employee_id'   => $request->employee_id[$i],
                'salary_type_id' => $request->salary_type_id[$i],
                'job_id'        => $request->job_id[$i],
                'status'        => $request->status[$i],
                'worked_hours'  => $request->worked_hours[$i],
                'over_time'     => $request->over_time[$i],
            ]);
        }
    }

    public function updateDetail(Request $request, $attendanceId, $detailId)
    {
        // dd($request->all());
        $detail = AttendanceDetail::findOrFail($detailId);

        $detail->update([
            'status' => $request->status,
            'job_id' => $request->job_id,
            'worked_hours' => $request->worked_hours ?? 0,
            'over_time' => $request->over_time ?? 0,
        ]);

        return redirect()->back()->with('success', 'Attendance updated successfully!');
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
