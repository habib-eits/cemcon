<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeDetailController extends Controller
{
    public function salaryDetail($employee_id)
    {
        $allowance = DB::table('allowance_list')->get();
        $emp_salary = DB::table('v_emp_salary')->where('EmployeeID',$employee_id)->get();
        $salary = DB::table('salary')->where('EmployeeID',$employee_id)->get();
        $employee = DB::table('v_employee')->where('EmployeeID',$employee_id)->first();

        return view('employee_details.salary',compact('salary','employee','allowance','emp_salary'));

    }
}
