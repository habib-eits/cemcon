<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    public $primaryKey = 'EmployeeID';


    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class,'JobTitleID','JobTitleID');
    }
    public function supervisor()
    {
        return $this->belongsTo(self::class,'SupervisorID','EmployeeID');
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'DepartmentID');
    }
}
