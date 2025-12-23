<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;

    protected $table = 'attendance_details';

    protected $fillable = [
        'attendance_id',
        'date',
        'employee_id',
        'salary_type_id',
        'job_id',
        'status',
        'office_hours',
        'worked_hours',
        'over_time',
        'days',
        'branch_id',
    ];

    /**
     * Belongs to Attendance header
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }

    /**
     * Belongs to Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'EmployeeID');
    }
}
