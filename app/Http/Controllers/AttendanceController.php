<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $pagetitle = 'Attendance';
        $attendance = DB::table('attendance_master')->get();
        return view('hr-hamza.attendance', compact('pagetitle', 'attendance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagetitle = 'Attendance';

        // Get active employees with salary info
        $employees = DB::table('v_emp_salary')
            ->where('StaffType', '<>', 'Inactive')
            ->orderBy('EmployeeID')
            ->get();

        $job = DB::table('job')->get();

        $fixed = $employees->where('AllowanceListID', 1);
        $fixed_ot = $employees->where('AllowanceListID', 2);
        $hourly = $employees->where('AllowanceListID', 3);
        $perday = $employees->where('AllowanceListID', 4);

        return view('hr-hamza.attendance_create', compact('pagetitle', 'employees', 'job', 'fixed', 'fixed_ot', 'hourly', 'perday'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate date
        $request->validate([
            'Date' => 'required|date',
            'EmployeeID' => 'required|array',
            'JobID' => 'required|array',
        ]);

        $exists = DB::table('attendance_master')
            ->where('Date', $request->Date)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('attendances.create')
                ->with('error', 'Attendance for this date already exists!')
                ->with('class', 'warning');
        }

        // Insert master record
        $masterId = DB::table('attendance_master')->insertGetId([
            'UserID' => Session::get('UserID'),
            'Date'   => $request->Date,
        ]);

        $insertData = [];
        for ($i = 0; $i < count($request->EmployeeID); $i++) {
            $insertData[] = [
                'EmployeeID'   => $request->EmployeeID[$i],
                'SalaryTypeID' => $request->SalaryTypeID[$i] ?? null,
                'Date'         => $request->Date,
                'JobID'        => $request->JobID[$i] ?? null,
                'Attendance'   => $request->Attendance[$i] ?? 0,
                'OverTime'     => $request->OT[$i] ?? 0,
                'PerHour'      => $request->PerHour[$i] ?? 0,
                'PerDay'       => $request->PerDay[$i] ?? 0,
            ];
        }
        DB::table('attendance')->insert($insertData);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance saved successfully!')
            ->with('class', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {
        $pagetitle = 'Attendance Details';

        $attendance = DB::table('v_attendance')->where('Date', $date)->get();

        if ($attendance->isEmpty()) {
            $attendance = collect();
        }

        $fixed     = $attendance->where('SalaryType', 'Fixed Salary');
        $fixed_ot  = $attendance->where('SalaryType', 'Fixed Salary + Over Time');
        $hourly    = $attendance->where('SalaryType', 'Hourly Paid');
        $perday    = $attendance->where('SalaryType', 'Per day');

        return view('hr-hamza.attendance_view', compact(
            'pagetitle',
            'date',
            'attendance',
            'fixed',
            'fixed_ot',
            'hourly',
            'perday'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($date)
    {

        DB::table('attendance')->where('Date', $date)->delete();

        DB::table('attendance_master')->where('Date', $date)->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Attendance deleted successfully!')
            ->with('class', 'success');
    }
}
