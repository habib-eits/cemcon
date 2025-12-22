<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    

        $employees =  Employee::with([
            'jobTitle',
            'supervisor',
            'department',
            ])
            ->where('StaffType', '<>', 'Inactive')
            ->orderBy('EmployeeID');
            
        return view('attendances.create', [
            'branches' =>  DB::table('branch')->get(),
            'jobs' =>  DB::table('job')->get(),
            'fixed' => $employees->where('SalaryTypeID', 1)->get(),
            'fixed_ot' => $employees->where('SalaryTypeID', 2)->get(),
            'hourly' => $employees->where('SalaryTypeID', 3)->get(),
            'perday' => $employees->where('SalaryTypeID', 4)->get(),
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
            'date' => 'required',
            'branch_id' => 'required',
        ]);

        $is_exists = Attendance::where([
            'branch_id' => $request->branch_id,
            'date' => $request->date,
        ])
        ->exists();

        if ($is_exists) {
            return back()->withErrors([
                'date' => 'Attendance already exists for this branch on this date.',
            ]);
        }

        $validated['user_id'] = Session::get('UserID') ?? null;

        $attendance =  Attendance::create($validated);

        return redirect()->back()->with('success', 'Attendance created successfully.');

        
        
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
