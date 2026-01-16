<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\SalaryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SalaryController extends Controller
{
    public $service;

    public function __construct(SalaryService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salaries = Salary::orderBy('salary_month', 'desc')->get();
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
            'office_hours_per_day' => 'required|numeric|min:0',
            'overtime_working_day_rate' => 'required|numeric|min:1',
            'overtime_holiday_rate'    => 'required|numeric|min:1',
            'branch_id'         => 'required|exists:branch,BranchID',
        ]);

        $is_exists = $this->service->isSalaryCreated($request);

        if ($is_exists) {
            return back()->withErrors([
                'date' => 'Salary already exists for this branch on this peroid.',
            ]);
        }

        $validated['user_id'] = Session::get('UserID') ?? null;
        $validated['is_locked'] = 0;

        $salary =  Salary::create($validated);

        return redirect()->route('salaries.edit',$salary->id);

        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Load salary with related branch, salary details, employee, job title, and salary type
        $salary = Salary::with([
            'branch',           // branch details
            'details.employee', // employee related to salary details
            'details.jobTitle', // job title of employee
            'details.salaryType', // salary type of each detail
        ])->findOrFail($id);

        // Group salary details by Salary Type and format for the Blade
        $salaryTypes = $salary->details->groupBy('salary_type_id')->map(function ($group) {
            return [
                'name' => $group->first()->salaryType->SalaryType ?? 'N/A', // get SalaryType name
                'employees' => $group
            ];
        })->values();

        return view('salaries.show', compact('salary', 'salaryTypes'));
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

        $employees = Employee::with(['jobTitle', 'supervisor', 'department'])
            ->where('StaffType', '<>', 'Inactive')
            ->where('BranchID', $salary->branch_id)
            ->orderBy('EmployeeID')
            ->select('EmployeeID','SalaryTypeID','FirstName','JobTitleID','Salary')
            ->get();

        $employees->each(function ($employee) use ($period, $salary) {

            $attendanceSummary = $this->service
                ->getEmployeeMonthlyAttendanceTotals($employee, $period);

            $salaryData = $this->service
                ->getEmployeeSalaryCalculations($employee, $salary, $attendanceSummary);

            // Attach calculated fields to employee
            foreach ($salaryData as $key => $value) {
                $employee->{$key} = $value;
            }
        });

        $employeesBySalary = $employees->groupBy('SalaryTypeID');

        $salaryTypes = [
            ['name' => 'Fixed Salary', 'employees' => $employeesBySalary->get(1, collect())],
            ['name' => 'Fixed Salary + Over Time', 'employees' => $employeesBySalary->get(2, collect())],
            ['name' => 'Hourly', 'employees' => $employeesBySalary->get(3, collect())],
            ['name' => 'Per Day', 'employees' => $employeesBySalary->get(4, collect())],
        ];

        return view('salaries.edit', [
            'salary' => $salary,
            'branches' => DB::table('branch')->get(),
            'jobs' => DB::table('job')->get(),
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
        foreach($request->employee_id as $index => $employeeId){
            DB::table('salary_details')->updateOrInsert(
                [
                    'salary_id' => $id,
                    'employee_id' => $employeeId,
                ],
                [
                    'salary_type_id' => $request->salary_type_id[$index],
                    'job_title_id' => $request->job_title_id[$index],
                    'salary_base_amount' => $request->salary_base_amount[$index],
                    'salary_base_per_day' => $request->salary_base_per_day[$index],
                    'salary_base_type' => 'gross',
                    'basic_worked_hours' => $request->basic_worked_hours[$index],
                    'basic_hourly_rate' => $request->basic_hourly_rate[$index],
                    'basic_total' => $request->basic_total[$index],
                    'overtime_hours' => $request->overtime_hours[$index],
                    'overtime_hourly_rate' => $request->overtime_hourly_rate[$index],
                    'overtime_total' => $request->overtime_total[$index],
                    'holiday_overtime_hourly_rate' => $request->holiday_overtime_hourly_rate[$index],
                    'holiday_overtime_hours' => $request->holiday_overtime_hours[$index],
                    'holiday_overtime_total' => $request->holiday_overtime_total[$index],
                    'gross_salary' => $request->gross_salary[$index],
                    'advance_paid' => $request->advance_paid[$index],
                    'net_salary' => $request->net_salary[$index],
                    'updated_at' => now(),
                ]
            );
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salary = Salary::find($id);
        $salary->details()->delete();
        $salary->delete();
        return redirect()->route('salaries.index');


    }
}
