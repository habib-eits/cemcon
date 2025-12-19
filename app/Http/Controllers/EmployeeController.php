<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function employeeCreate()
    {
        $branch = DB::table('branch')->get();
        $title = DB::table('title')->get();
        $jobtitle = DB::table('jobtitle')->get();
        $staff_type = DB::table('staff_type')->get();
        $supervisor = DB::table('employee')
            ->select('EmployeeID', DB::raw("CONCAT(FirstName, ' ', LastName) AS full_name"))
            ->where('IsSupervisor', 'Yes')
            ->get();
        $department = DB::table('department')->get();
        $country = DB::table('country')->get();
        $educationlevel = DB::table('educationlevel')->get();
        $salary_type = DB::table('salary_type')->get();

        return view('hr.employee_create',[
            'branch' => $branch,
            'title' =>  $title,
            'jobtitle' => $jobtitle,
            'staff_type' => $staff_type,
            'supervisor' => $supervisor,
            'department' => $department,
            'country' => $country,
            'educationlevel' => $educationlevel,
            'salary_type' => $salary_type,
        ]);
    }

    public function employeeSave(Request $request)
    {
        // dd($request->emp_pic->getClientOriginalExtension());
        $data = $request->validate([
            'BranchID' => 'nullable',
            'Title' => 'nullable',
            'IsSupervisor' => 'nullable',
            'FirstName' => 'nullable|string',
            'MiddleName' => 'nullable|string',
            'LastName' => 'nullable|string',
            'DateOfBirth' => 'nullable|date',
            'Gender' => 'nullable',
            'Email' => 'nullable|email',
            'Nationality' => 'nullable',
            'MobileNo' => 'nullable',
            'HomePhone' => 'nullable',
            'FullAddress' => 'nullable',
            'EducationLevel' => 'nullable',
            'LastDegree' => 'nullable',
            'MaritalStatus' => 'nullable',
            'SSNorGID' => 'nullable',
            'SpouseName' => 'nullable',
            'SpouseEmployer' => 'nullable',
            'SpouseWorkPhone' => 'nullable',
            'VisaIssueDate' => 'nullable|date',
            'VisaExpiryDate' => 'nullable|date',
            'PassportNo' => 'nullable',
            'PassportExpiry' => 'nullable|date',
            'EidNo' => 'nullable',
            'EidExpiry' => 'nullable|date',
            'NextofKinName' => 'nullable',
            'NextofKinAddress' => 'nullable',
            'NextofKinPhone' => 'nullable',
            'NextofKinRelationship' => 'nullable',
            'JobTitleID' => 'nullable',
            'DepartmentID' => 'nullable',
            'SupervisorID' => 'nullable',
            'WorkLocation' => 'nullable',
            'EmailOffical' => 'nullable|email',
            'WorkPhone' => 'nullable',
            'StartDate' => 'nullable|date',
            'Salary' => 'nullable|numeric',
            'ExtraComission' => 'nullable|numeric',
            'SalaryRemarks' => 'nullable',
            'StaffType' => 'nullable',
            'SalaryTypeID' => 'nullable',
            'em_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:20000',
        ]);

        if ($request->hasFile('em_pic')) {
            $file = $request->file('em_pic');
            $targetPath = public_path('emp-picture');

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($targetPath, $fileName);

            $data['picture_path'] = 'emp-picture/' . $fileName;
        }
        // dd($request);

        DB::table('employee')->insert($data);

        return response()->json(['success' => true]);
    }

    public function employeeEdit($id)
    {
        $branch = DB::table('branch')->get();
        $title = DB::table('title')->get();
        $jobtitle = DB::table('jobtitle')->get();
        $staff_type = DB::table('staff_type')->get();
        $department = DB::table('department')->get();
        $country = DB::table('country')->get();
        $educationlevel = DB::table('educationlevel')->get();
        $salary_type = DB::table('salary_type')->get();
        $supervisor = DB::table('employee')
            ->select(
                'EmployeeID',
                DB::raw("CONCAT(FirstName, ' ', LastName) AS full_name")
            )
            ->where('IsSupervisor', 'Yes')
            ->where('EmployeeID', '!=', $id)
            ->get();
        $employee = DB::table('employee')
            ->where('EmployeeID', $id)
            ->first();

        return view('hr.employeeedit', [
            'employee' => $employee,
            'branch' => $branch,
            'title' => $title,
            'jobtitle' => $jobtitle,
            'staff_type' => $staff_type,
            'supervisor' => $supervisor,
            'department' => $department,
            'country' => $country,
            'educationlevel' => $educationlevel,
            'salary_type' => $salary_type,
        ]);
    }

    public function employeeUpdate(Request $request, $id)
    {
        // dd($id);

        $id = $request->EmployeeID;
        $data = $request->validate([
            'BranchID' => 'nullable',
            'Title' => 'nullable',
            'IsSupervisor' => 'nullable',
            'FirstName' => 'nullable|string',
            'MiddleName' => 'nullable|string',
            'LastName' => 'nullable|string',
            'DateOfBirth' => 'nullable|date',
            'Gender' => 'nullable',
            'Email' => 'nullable|email',
            'Nationality' => 'nullable',
            'MobileNo' => 'nullable',
            'HomePhone' => 'nullable',
            'FullAddress' => 'nullable',
            'EducationLevel' => 'nullable',
            'LastDegree' => 'nullable',
            'MaritalStatus' => 'nullable',
            'SSNorGID' => 'nullable',
            'SpouseName' => 'nullable',
            'SpouseEmployer' => 'nullable',
            'SpouseWorkPhone' => 'nullable',
            'VisaIssueDate' => 'nullable|date',
            'VisaExpiryDate' => 'nullable|date',
            'PassportNo' => 'nullable',
            'PassportExpiry' => 'nullable|date',
            'EidNo' => 'nullable',
            'EidExpiry' => 'nullable|date',
            'NextofKinName' => 'nullable',
            'NextofKinAddress' => 'nullable',
            'NextofKinPhone' => 'nullable',
            'NextofKinRelationship' => 'nullable',
            'JobTitleID' => 'nullable',
            'DepartmentID' => 'nullable',
            'SupervisorID' => 'nullable',
            'WorkLocation' => 'nullable',
            'EmailOffical' => 'nullable|email',
            'WorkPhone' => 'nullable',
            'StartDate' => 'nullable|date',
            'Salary' => 'nullable|numeric',
            'ExtraComission' => 'nullable|numeric',
            'SalaryRemarks' => 'nullable',
            'StaffType' => 'nullable',
            'SalaryTypeID' => 'nullable',
            'em_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:20000',
        ]);

        if ($request->hasFile('em_pic')) {
            $file = $request->file('em_pic');
            $targetPath = public_path('emp-picture');

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $oldImage = DB::table('employee')
                ->where('EmployeeID', $id)
                ->value('picture_path');

            if ($oldImage && file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($targetPath, $fileName);

            $data['picture_path'] = 'emp-picture/' . $fileName;
        }

        // dd($request);

        DB::table('employee')
            ->where('EmployeeID', $id)
            ->update($data);

         return redirect('EmployeeDetail/'.$id)
            ->with('error', 'Record Updated Successfully')
            ->with('class', 'success');
    }

    public function employeeDelete($id)
    {
         $idd = DB::table('employee')->where('EmployeeID',$id)->delete();
        return redirect('Employee')->with('error',' Deleted Successfully')->with('class','danger');
    }
}
