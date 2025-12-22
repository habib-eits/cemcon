<?php

namespace App\Http\Controllers\Hr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeLetterController extends Controller
{
    // Helper: Fetch employee safely
    private function getEmployee($employeeId)
    {
        return DB::table('v_employee')
            ->where('EmployeeID', $employeeId)
            ->first();
    }

    // List all issued letters
    public function index($employeeId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Letter Issue / Letter Issued')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $employee = $this->getEmployee($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found')->with('class', 'warning');
        }

        $letter = DB::table('letter')->get();
        $issue_letter = DB::table('issue_letter')
            ->where('EmployeeID', $employeeId)
            ->orderByDesc('IssueLetterID')
            ->get();

        return view('hr-hamza.emp.emp_letter', compact('letter', 'issue_letter', 'employee'));
    }

    // List warning letters (same as index but different view or filter)
    public function warnings($employeeId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Warning Letter List')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $employee = $this->getEmployee($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found')->with('class', 'warning');
        }

        $letter = DB::table('letter')->get();
        $issue_letter = DB::table('issue_letter')
            ->where('EmployeeID', $employeeId)
            ->get();

        return view('hr.emp.emp_warning_letter', compact('letter', 'issue_letter', 'employee'));
    }

    // Preview letter template
    public function preview(Request $request, $employeeId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Letter Issue / Letter Issued')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $employee = $this->getEmployee($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found')->with('class', 'warning');
        }

        $letter = DB::table('letter')
            ->where('LetterID', $request->LetterID)
            ->first();

        if (!$letter) {
            return redirect()->back()->with('error', 'Letter template not found')->with('class', 'warning');
        }

        return view('hr-hamza.emp.letter_issue_preview', compact('letter', 'employee'));
    }

    // Save new issued letter
    public function store(Request $request, $employeeId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Letter Issue / Letter Issued')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $employee = $this->getEmployee($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found')->with('class', 'warning');
        }

        $request->validate([
            'LetterID' => 'required|exists:letter,LetterID',
            'Title'    => 'required|string|max:255',
            'Content'  => 'required',
        ]);

        DB::table('issue_letter')->insert([
            'EmployeeID' => $employeeId,
            'LetterID'   => $request->LetterID,
            'Title'      => $request->Title,
            'Content'    => $request->Content,
            'UserID'     => session('UserID'),
        ]);

        return redirect()->route('employee.letters', $employeeId)
            ->with('error', 'Letter Issued Successfully')
            ->with('class', 'success');
    }

    // Edit form
    public function edit($employeeId, $issueLetterId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Issued Letter Update')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $employee = $this->getEmployee($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found')->with('class', 'warning');
        }

        $issue_letter = DB::table('issue_letter')
            ->where('IssueLetterID', $issueLetterId)
            ->where('EmployeeID', $employeeId)
            ->first();

        if (!$issue_letter) {
            return redirect()->back()->with('error', 'Letter not found')->with('class', 'warning');
        }

        return view('hr-hamza.emp.letter_issue_edit', compact('issue_letter', 'employee'));
    }

    // Update letter
    public function update(Request $request, $employeeId, $issueLetterId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Issued Letter Update')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $request->validate([
            'Title'   => 'required|string|max:255',
            'Content' => 'required',
        ]);

        $updated = DB::table('issue_letter')
            ->where('IssueLetterID', $issueLetterId)
            ->where('EmployeeID', $employeeId)
            ->update([
                'Title'      => $request->Title,
                'Content'    => $request->Content,
                'UserID'     => session('UserID'),
                'updated_at' => now(),
            ]);

        return redirect()->route('employee.letters', $employeeId)
            ->with('error', $updated ? 'Letter Updated Successfully' : 'Nothing to update')
            ->with('class', $updated ? 'success' : 'info');
    }

    // Delete letter
    public function destroy($employeeId, $issueLetterId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Delete Issued Letter')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $deleted = DB::table('issue_letter')
            ->where('IssueLetterID', $issueLetterId)
            ->where('EmployeeID', $employeeId)
            ->delete();

        return redirect()->route('employee.letters', $employeeId)
            ->with('error', $deleted ? 'Letter Deleted Successfully' : 'Letter not found')
            ->with('class', $deleted ? 'success' : 'danger');
    }

    // Print / View issued letter
    public function print($employeeId, $issueLetterId)
    {
        if (!check_hr_role(session('UserID'), session('BranchID'), 'Employee Detail', 'Print Issued Letter')) {
            return redirect()->back()->with('error', 'Your access is limited')->with('class', 'danger');
        }

        $issue_letter = DB::table('issue_letter')
            ->where('IssueLetterID', $issueLetterId)
            ->where('EmployeeID', $employeeId)
            ->first();

        if (!$issue_letter) {
            return redirect()->back()->with('error', 'Letter not found')->with('class', 'warning');
        }

        $employee = $this->getEmployee($employeeId);

        return view('hr-hamza.issue_letter_print', compact('issue_letter', 'employee'));
    }
}
