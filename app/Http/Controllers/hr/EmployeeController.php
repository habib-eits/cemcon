<?php

namespace App\Http\Controllers\hr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

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
    public function store(Request $request)
    {
        /* ================= USER RIGHTS ================= */
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Create')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        /* ================= VALIDATION ================= */
        $request->validate([
            'BranchID'  => 'required',
            'FirstName' => 'required',
            'DateOfBirth' => 'required|date',
            'IsSupervisor' => 'required|in:Yes,No',
            'StaffType' => 'required',
            'Email' => 'required|email',
            'StartDate' => 'required|date',
            'UploadSlip' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ], [
            'BranchID.required'  => 'Branch is required',
            'FirstName.required' => 'First Name is required',
        ]);

        /* ================= FILE UPLOAD ================= */
        $filename = null;
        if ($request->file('UploadSlip') != null) {
            $this->validate($request, [
                'UploadSlip' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
            ]);

            $file = $request->file('UploadSlip');
            $filename = time() . '.' . $file->extension();
            $destinationPath = public_path('/emp-picture');
            $file->move($destinationPath, $filename);
        }

        /* ================= DATA PREPARATION ================= */
        $data = [
            'BranchID'              => $request->BranchID,
            'Title'                 => $request->Title,
            'IsSupervisor'          => $request->IsSupervisor,
            'FirstName'             => $request->FirstName,
            'MiddleName'            => $request->MiddleName,
            'LastName'              => $request->LastName,
            'DateOfBirth'           => $this->formatDate($request->DateOfBirth),
            'Gender'                => $request->Gender,
            'Email'                 => $request->Email,
            'Nationality'           => $request->Nationality,
            'MobileNo'              => $request->MobileNo,
            'HomePhone'             => $request->HomePhone,
            'FullAddress'           => $request->FullAddress,
            'EducationLevel'        => $request->EducationLevel,
            'LastDegree'            => $request->LastDegree,
            'MaritalStatus'         => $request->MaritalStatus,
            'SSNorGID'              => $request->SSNorGID,
            'SpouseName'            => $request->SpouseName,
            'SpouseEmployer'        => $request->SpouseEmployer,
            'SpouseWorkPhone'       => $request->SpouseWorkPhone,
            'VisaIssueDate'         => $this->formatDate($request->VisaIssueDate),
            'VisaExpiryDate'        => $this->formatDate($request->VisaExpiryDate),
            'PassportNo'            => $request->PassportNo,
            'PassportExpiry'        => $this->formatDate($request->PassportExpiry),
            'EidNo'                 => $request->EidNo,
            'EidExpiry'             => $this->formatDate($request->EidExpiry),
            'NextofKinName'         => $request->NextofKinName,
            'NextofKinAddress'      => $request->NextofKinAddress,
            'NextofKinPhone'        => $request->NextofKinPhone,
            'NextofKinRelationship' => $request->NextofKinRelationship,
            'JobTitleID'            => $request->JobTitleID,
            'DepartmentID'          => $request->DepartmentID,
            'SupervisorID'          => $request->SupervisorID,
            'WorkLocation'          => $request->WorkLocation,
            'EmailOffical'          => $request->EmailOffical,
            'WorkPhone'             => $request->WorkPhone,
            'StartDate'             => $this->formatDate($request->StartDate),
            'Salary'                => $request->Salary,
            'ExtraComission'        => $request->ExtraComission,
            'SalaryRemarks'         => $request->SalaryRemarks,
            'StaffType'             => $request->StaffType,
            'SalaryTypeID'          => $request->SalaryTypeID,
            'BankName'              => $request->BankName,
            'IBAN'                  => $request->IBAN,
            'AccountTitle'          => $request->AccountTitle,
            'Picture'               => $filename,
        ];

        /* ================= INSERT ================= */
        DB::table('employee')->insert($data);

        return redirect('employees')
            ->with('error', 'Employee Record Saved Successfully')
            ->with('class', 'success');
    }


    /* ================= DATE FORMAT HELPER ================= */
    private function formatDate($date)
    {
        return $date ? date('Y-m-d', strtotime(str_replace('/', '-', $date))) : null;
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // ================= USER RIGHTS =================
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee', 'Update')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        // ================= VALIDATION =================
        $request->validate([
            'BranchID'  => 'required',
            'FirstName' => 'required',
            'DateOfBirth' => 'required|date',
            'IsSupervisor' => 'required|in:Yes,No',
            'StaffType' => 'required',
            'Email' => 'required|email',
            'StartDate' => 'required|date',
            'UploadSlip' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ], [
            'BranchID.required'  => 'Branch is required',
            'FirstName.required' => 'First Name is required',
        ]);

        // ================= FETCH EMPLOYEE =================
        $employee = DB::table('employee')->where('EmployeeID', $id)->first();
        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        // ================= FILE UPLOAD =================
        $filename = $employee->Picture; // keep old picture if no new upload
        if ($request->hasFile('UploadSlip')) {
            $file = $request->file('UploadSlip');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('emp-picture'), $filename);
        }

        // ================= DATA PREPARATION =================
        $data = [
            'BranchID'              => $request->BranchID,
            'Title'                 => $request->Title,
            'IsSupervisor'          => $request->IsSupervisor,
            'FirstName'             => $request->FirstName,
            'MiddleName'            => $request->MiddleName,
            'LastName'              => $request->LastName,
            'DateOfBirth'           => $this->formatDate($request->DateOfBirth),
            'Gender'                => $request->Gender,
            'Email'                 => $request->Email,
            'Nationality'           => $request->Nationality,
            'MobileNo'              => $request->MobileNo,
            'HomePhone'             => $request->HomePhone,
            'FullAddress'           => $request->FullAddress,
            'EducationLevel'        => $request->EducationLevel,
            'LastDegree'            => $request->LastDegree,
            'MaritalStatus'         => $request->MaritalStatus,
            'SSNorGID'              => $request->SSNorGID,
            'SpouseName'            => $request->SpouseName,
            'SpouseEmployer'        => $request->SpouseEmployer,
            'SpouseWorkPhone'       => $request->SpouseWorkPhone,
            'VisaIssueDate'         => $this->formatDate($request->VisaIssueDate),
            'VisaExpiryDate'        => $this->formatDate($request->VisaExpiryDate),
            'PassportNo'            => $request->PassportNo,
            'PassportExpiry'        => $this->formatDate($request->PassportExpiry),
            'EidNo'                 => $request->EidNo,
            'EidExpiry'             => $this->formatDate($request->EidExpiry),
            'NextofKinName'         => $request->NextofKinName,
            'NextofKinAddress'      => $request->NextofKinAddress,
            'NextofKinPhone'        => $request->NextofKinPhone,
            'NextofKinRelationship' => $request->NextofKinRelationship,
            'JobTitleID'            => $request->JobTitleID,
            'DepartmentID'          => $request->DepartmentID,
            'SupervisorID'          => $request->SupervisorID,
            'WorkLocation'          => $request->WorkLocation,
            'EmailOffical'          => $request->EmailOffical,
            'WorkPhone'             => $request->WorkPhone,
            'StartDate'             => $this->formatDate($request->StartDate),
            'Salary'                => $request->Salary,
            'ExtraComission'        => $request->ExtraComission,
            'SalaryRemarks'         => $request->SalaryRemarks,
            'StaffType'             => $request->StaffType,
            'SalaryTypeID'          => $request->SalaryTypeID,
            'BankName'              => $request->BankName,
            'IBAN'                  => $request->IBAN,
            'AccountTitle'          => $request->AccountTitle,
            'Picture'               => $filename,
        ];

        // ================= UPDATE =================
        DB::table('employee')->where('EmployeeID', $id)->update($data);

        // return redirect('EmployeeDetail/' . $id)
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
        // dd($id);
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
