<?php

namespace App\Http\Controllers\Hr;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Only load the view
        return view('hr-hamza.employee');
    }

    public function employee_ajax(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('v_employee')
                ->orderBy('EmployeeID', 'asc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('FullName', function ($row) {
                    return trim($row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName);
                })

                ->addColumn('action', function ($row) {

                    return '
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a onclick="view_data(' . $row->EmployeeID . ')" class="dropdown-item">
                                    <i class="mdi mdi-eye font-size-16 text-secondary me-1"></i> View
                                </a>
                            </li>
                            <li>
                                <a onclick="edit_data(' . $row->EmployeeID . ')" class="dropdown-item">
                                    <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a onclick="delete_confirm22(' . $row->EmployeeID . ')" class="dropdown-item">
                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branch = DB::table('branch')->get();
        $title = DB::table('title')->get();
        $jobtitle = DB::table('jobtitle')->get();
        $staff_type = DB::table('staff_type')->get();
        $supervisor = DB::table('employee')
            ->where('IsSupervisor', 'Yes')
            ->get();
        $department = DB::table('department')->get();
        $country = DB::table('country')->get();
        $educationlevel = DB::table('educationlevel')->get();
        $salary_type = DB::table('salary_type')->get();
        return view('hr-hamza.employee_create', [
            'branch' => $branch,
            'title' => $title,
            'jobtitle' => $jobtitle,
            'staff_type' => $staff_type,
            'supervisor' => $supervisor,
            'department' => $department,
            'country' => $country,
            'educationlevel' => $educationlevel,
            'salary_type' => $salary_type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request, EmployeeService $employeeService)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Create')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $picture = $employeeService->handleUpload($request);

        $data = $employeeService->prepareData($request->validated(), $picture);

        $employeeService->create($data);

        return redirect('employees')
            ->with('error', 'Employee Record Saved Successfully')
            ->with('class', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Detail')) {
            return redirect('Dashboard')
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $employee = DB::table('v_employee')
            ->where('EmployeeID', $id)
            ->first();

        if (!$employee) {
            return redirect('employees')
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        $startDate = $employee->StartDate ?? '1970-01-01';
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate);
        $to = \Carbon\Carbon::today();
        $diffInMonths = $to->diffInMonths($from);

        session([
            'EmployeeID' => $id,
            'StartDate'  => $employee->StartDate,
            'Months'     => $diffInMonths,
        ]);

        return view('hr-hamza.employee_detail', compact('employee', 'diffInMonths'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Update')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $employee = DB::table('employee')
            ->where('EmployeeID', $id)
            ->first();

        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        $branch = DB::table('branch')->get();
        $title = DB::table('title')->get();
        $jobtitle = DB::table('jobtitle')->get();
        $staff_type = DB::table('staff_type')->get();
        $supervisor = DB::table('employee')
            ->where('IsSupervisor', 'Yes')
            ->get();
        $department = DB::table('department')->get();
        $country = DB::table('country')->get();
        $educationlevel = DB::table('educationlevel')->get();
        $salary_type = DB::table('salary_type')->get();

        return view('hr-hamza.employeeedit', [
            'employee' => $employee,
            'branch' => $branch,
            'title' => $title,
            'jobtitle' => $jobtitle,
            'staff_type' => $staff_type,
            'supervisor' => $supervisor,
            'department' => $department,
            'country' => $country,
            'educationlevel' => $educationlevel,
            'salary_type' => $salary_type
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id, EmployeeService $employeeService)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Update')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $employee = $employeeService->find($id);
        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        $picture = $employeeService->handleUpload($request) ?? $employee->Picture;

        $data = $employeeService->prepareData($request->validated(), $picture);

        $employeeService->update($id, $data);

        return redirect('employees')
            ->with('error', 'Employee Record Updated Successfully')
            ->with('class', 'success');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Delete')) {
            return redirect('Dashboard')
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $deleted = DB::table('employee')
            ->where('EmployeeID', $id)
            ->delete();

        if (!$deleted) {
            return redirect('employees')
                ->with('error', 'Employee record not found')
                ->with('class', 'warning');
        }

        return redirect('employees')
            ->with('success', 'Employee deleted successfully')
            ->with('class', 'danger');
    }
}
