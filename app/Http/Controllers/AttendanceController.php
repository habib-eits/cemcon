<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function create()
    {
        $attendance = DB::table('attendance')->get();
        $job = DB::table('job')->get();

        $salaryType1 = DB::table('Employee')
            ->where('StaffType', '<>', 'Inactive')
            ->where('SalaryTypeID', 1)
            ->orderBy('EmployeeID')
            ->get();

        $salaryType2 = DB::table('Employee')
            ->where('StaffType', '<>', 'Inactive')
            ->where('SalaryTypeID', 2)
            ->orderBy('EmployeeID')
            ->get();

        $salaryType3 = DB::table('Employee')
            ->where('StaffType', '<>', 'Inactive')
            ->where('SalaryTypeID', 3)
            ->orderBy('EmployeeID')
            ->get();

        $salaryType4 = DB::table('Employee')
            ->where('StaffType', '<>', 'Inactive')
            ->where('SalaryTypeID', 4)
            ->orderBy('EmployeeID')
            ->get();

        return view('hr.attendance_create', [
            'attendance' => $attendance,
            'job' => $job,
            'salaryType1' => $salaryType1,
            'salaryType2' => $salaryType2,
            'salaryType3' => $salaryType3,
            'salaryType4' => $salaryType4,
        ]);
    }

    public function save()
    {

    }

    public function show(Request $request)
    {
        $date = $request->Date;

        $attendance = DB::table('v_attendance')
            ->where('Date', $date)
            ->get();

        $salaryTypes = [
            1 => 'Fixed Salary',
            2 => 'Fixed + Overtime',
            3 => 'Hourly Based',
            4 => 'Daily Based',
        ];

        $attendanceBySalaryType = [];
        foreach ($salaryTypes as $typeId => $typeTitle) {
            $attendanceBySalaryType[$typeId] = $attendance->where('SalaryTypeID', $typeId);
        }

        return view('hr.attendance_view', compact('attendanceBySalaryType', 'salaryTypes', 'date','attendance'));
    }
}
