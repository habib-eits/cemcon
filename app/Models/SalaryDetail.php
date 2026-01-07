<?php

namespace App\Models;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_id',
        'employee_id',
        'job_title_id',

        // Basic salary
        'basic_salary',
        'basic_hourly_rate',
        'basic_hours_worked',
        'basic_total',

        // Overtime
        'overtime_hourly_rate',
        'overtime_hours',
        'overtime_total',

        // Final amounts
        'gross_salary',
        'advance_paid',
        'net_salary',
    ];

    // Relationships
    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
}
