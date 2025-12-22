<?php

namespace App\Http\Controllers\Hr;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeDetailController extends Controller
{
    /**
     * Show Employee Salary Details
     */
    public function salary($employeeId)
    {
        // User Rights Check
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Salary View')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        // Fetch employee first to validate existence
        $employee = DB::table('v_employee')
            ->where('EmployeeID', $employeeId)
            ->first();

        if (!$employee) {
            return redirect()->route('employees.index')
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        // Fetch related data
        $allowance  = DB::table('allowance_list')->get();

        $emp_salary = DB::table('v_emp_salary')
            ->where('EmployeeID', $employeeId)
            ->get();

        $salary = DB::table('salary')
            ->where('EmployeeID', $employeeId)
            ->orderByDesc('SalaryID')
            ->get();

        return view('hr-hamza.emp.emp_salary', compact(
            'salary',
            'employee',
            'allowance',
            'emp_salary'
        ));
    }

    /**
     * Save a new allowance for the employee
     */
    public function allowanceSave(Request $request, $employeeId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Salary Edit')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        $request->validate([
            'AllowanceListID' => 'required|exists:allowance_list,AllowanceListID',
            'Amount'          => 'required|numeric|min:0',
            'Active'          => 'required|in:Yes,No',
        ]);

        $employee = DB::table('v_employee')->where('EmployeeID', $employeeId)->first();
        if (!$employee) {
            return redirect()->back()
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        DB::table('emp_salary')->insert([
            'EmployeeID'      => $employeeId,
            'AllowanceListID' => $request->AllowanceListID,
            'Amount'          => $request->Amount,
            'Active'          => $request->Active,
        ]);

        return redirect()->back()
            ->with('error', 'Allowance added successfully')
            ->with('class', 'success');
    }

    /**
     * Delete an employee allowance
     */
    public function allowanceDelete($id)
    {
        // Permission check
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Salary Edit')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        // Delete the allowance
        $deleted = DB::table('emp_salary')
            ->where('EmployeeAllowanceID', $id)
            ->delete();

        if ($deleted) {
            return redirect()->back()
                ->with('error', 'Allowance deleted successfully')
                ->with('class', 'success');
        }

        return redirect()->back()
            ->with('error', 'Allowance not found or already deleted')
            ->with('class', 'danger');
    }

    /**
     * Generate and stream Salary Slip PDF for a specific salary record
     */
    public function empSalarySlip($employeeId, $salaryId = null)
    {
        // Permission check
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Salary View')) {
            return redirect()->back()
                ->with('error', 'Your access is limited')
                ->with('class', 'danger');
        }

        // Fetch employee to validate existence
        $employee = DB::table('v_employee')
            ->where('EmployeeID', $employeeId)
            ->first();

        if (!$employee) {
            return redirect()->back()
                ->with('error', 'Employee not found')
                ->with('class', 'warning');
        }

        // Fetch branch data (for header/logo etc.)
        $branch = DB::table('branch')->get();

        // Fetch salary record
        $query = DB::table('salary')
            ->where('EmployeeID', $employeeId);

        if ($salaryId) {
            $query->where('SalaryID', $salaryId);
        } else {
            $query->orderByDesc('SalaryID');
        }

        $salary = $query->first();

        if (!$salary) {
            return redirect()->back()
                ->with('error', 'No salary record found for this employee')
                ->with('class', 'warning');
        }

        // Generate PDF
        $pdf = PDF::loadView('salary_slip_pdf', compact('branch', 'salary', 'employee'));

        $pdf->setPaper('A4', 'portrait');

        // Optional: Save to server (uncomment if needed)
        // $filename = 'salary-slip-' . $salary->SalaryID . '-' . time() . '.pdf';
        // $pdf->save(public_path('uploads/salary-slips/' . $filename));

        // Stream to browser
        return $pdf->stream('salary-slip-' . $salary->MonthName . '-' . $salary->SalaryID . '.pdf');
    }
}
