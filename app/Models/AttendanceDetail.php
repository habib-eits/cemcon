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
        'over_time',
        'branch_id',
    ];
}
