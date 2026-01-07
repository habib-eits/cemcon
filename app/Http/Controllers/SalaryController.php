<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salaries = Salary::all();
        return view('salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            
        return view('salaries.create', [
            'branches' =>  DB::table('branch')->get(),
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
            'salary_month'     => 'required',
            'total_days'        => 'required|integer|min:1',
            'working_days'      => 'required|integer|min:0',
            'office_hours_per_day'      => 'required|numeric|min:0',
            'overtime_hourly_rate' => 'required|numeric|min:1',
            'basic_hourly_rate'    => 'required|numeric|min:1',
            'branch_id'         => 'required|exists:Branch,BranchID',
        ]);



        $is_exists = Salary::where('branch_id', $request->branch_id)
        ->whereYear('salary_month', Carbon::parse($request->salary_month)->year)
        ->whereMonth('salary_month', Carbon::parse($request->salary_month)->month)
        ->exists();

        if ($is_exists) {
            return back()->withErrors([
                'date' => 'Salary already exists for this branch on this peroid.',
            ]);
        }

        $validated['user_id'] = Session::get('UserID') ?? null;
        $validated['is_locked'] = 0;

        $salary =  Salary::create($validated);

        
        
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
        $salary = Salary::findOrFail($id);
        $period = Carbon::parse($salary->salary_month);


        $employees = Employee::with([
            'jobTitle',
            'supervisor',
            'department',
        ])

        ->where('StaffType', '<>', 'Inactive')
        ->where('BranchID', $salary->branch_id)
        ->orderBy('EmployeeID')
        ->select('EmployeeID','SalaryTypeID','FirstName','JobTitleID','Salary')
        ->get();

        $employees = $employees->each(function($employee) use ($period,$salary){

            $attendanceRecord = DB::table('attendance_details')
            ->where('employee_id', $employee->EmployeeID)
            ->whereMonth('date', $period->month)
            ->whereYear('date', $period->year);

            $workedHours    = $attendanceRecord->sum('worked_hours');
            $overtimeHours  = $attendanceRecord->sum('overtime');

            $basicRate = $employee->Salary != null
            ? $employee->Salary
            : $salary->basic_hourly_rate;

            $overtimeRate = $salary->overtime_hourly_rate;

            $basicAmount = $basicRate * $workedHours;
            $overtimeAmount = $overtimeRate * $overtimeHours;
            $grossAmount = $basicAmount + $overtimeAmount;
    
            // basic    
            $employee->basic_hourly_rate = $basicRate;
            $employee->worked_hours = $workedHours;
            $employee->basic_total = $basicAmount;
            
            // overtime
            $employee->overtime_hourly_rate = $overtimeRate;
            $employee->overtime_hours = $overtimeHours;
            $employee->overtime_total = $overtimeAmount;

            $employee->gross_salary = $grossAmount;
        });



        $employeesBySalary = $employees->groupBy('SalaryTypeID');
        $salaryTypes = [
            ['name' => 'Fixed Salary','employees' => $employeesBySalary->get(1, collect())],
            ['name' => 'Fixed Salary + Over Time','employees' => $employeesBySalary->get(2, collect())],
            ['name' => 'Hourly','employees' => $employeesBySalary->get(3, collect())],
            ['name' => 'Per Day','employees' => $employeesBySalary->get(4, collect())],
        ];

        return view('salaries.edit', [
            'salary' =>  $salary,
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
        //
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
