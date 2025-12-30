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
        //
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
            'salary_period'      => 'required|date_format:Y-m-d',
            'month_days'        => 'required|integer|min:1',
            'working_days'      => 'required|integer|min:0',
            'office_hours'      => 'required|numeric|min:0',
            'overtime_per_hour' => 'required|numeric|min:0',
            'branch_id'         => 'required|exists:Branch,BranchID',
        ]);


        $is_exists = Salary::where('branch_id', $request->branch_id)
        ->whereYear('salary_period', Carbon::parse($request->salary_period)->year)
        ->whereMonth('salary_period', Carbon::parse($request->salary_period)->month)
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
        //
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
