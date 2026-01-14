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
        'salary_type_id',
        'employee_id',
        'job_title_id',

        'salary_base_amount',
        'salary_base_per_day',
        'salary_base_type',

        'basic_hours_worked',
        'basic_hourly_rate',
        'basic_total',

        'overtime_hourly_rate',
        'overtime_hours',
        'overtime_total',
        
        'holiday_overtime_hourly_rate',
        'holiday_overtime_hours',
        'holiday_overtime_total',
        
        'gross_salary',
        'advance_paid',
        'net_salary',
    ];

    
    // Relationships
    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','EmployeeID');
    }
    public function salaryType()
    {
        return $this->belongsTo(SalaryType::class,'salary_type_id','SalaryTypeID');
    }
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class,'job_title_id','JobTitleID');
    }
}
