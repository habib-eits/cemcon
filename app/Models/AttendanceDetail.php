<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'date',
        'employee_id',
        'salary_type_id',
        'job_id',
        'status',
        'office_hours',
        'worked_hours',
        'overtime',
        'branch_id',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','EmployeeID');
    }
    public function salaryType()
    {
        return $this->belongsTo(SalaryType::class,'salary_type_id','SalaryTypeID');
    }
    public function job()
    {
        return $this->belongsTo(Job::class,'job_id','JobID');
    }
}
