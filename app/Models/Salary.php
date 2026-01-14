<?php

namespace App\Models;

use App\Models\User;
use App\Models\Branch;
use App\Models\SalaryDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'salary_month',
        'total_days',
        'working_days',
        'office_hours_per_day',
        'overtime_working_day_rate',
        'overtime_holiday_rate',
        'user_id',
        'branch_id',
        'is_locked',
    ];

    // Relationships
    public function details()
    {
        return $this->hasMany(SalaryDetail::class);
    }
     // Attendance belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','UserID');
    }

    // Attendance belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','BranchID');
    }

    
}
