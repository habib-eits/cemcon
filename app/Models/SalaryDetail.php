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
        'basic_salary_amount',
        'basic_hourly_rate',
        'basic_worked_hours',
        'basic_total_amount',

        // Overtime
        'overtime_hourly_rate',
        'overtime_hours',
        'overtime_total_amount',

        // Final amounts
        'gross_salary_amount',
        'advance_amount',
        'net_salary_amount',
    ];

    // Relationships
    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
}
