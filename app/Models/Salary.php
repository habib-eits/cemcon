<?php

namespace App\Models;

use App\Models\SalaryDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_period',
        'month_days',
        'working_days',
        'office_hours',
        'overtime_per_hour',
        'user_id',
        'branch_id',
        'is_locked',
    ];

    // Relationships
    public function details()
    {
        return $this->hasMany(SalaryDetail::class);
    }
}
