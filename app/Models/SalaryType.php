<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryType extends Model
{
    protected $table = 'salary_type';
    protected $primaryKey = 'SalaryTypeID';

    public $timestamps = false;

    protected $fillable = ['SalaryType'];

    public function attendanceDetails()
    {
        return $this->hasMany(
            AttendanceDetail::class,
            'salary_type_id',     
            'SalaryTypeID'        
        );
    }
}
