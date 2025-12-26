<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';
    protected $primaryKey = 'JobID';
    public $timestamps = false;

    protected $fillable = [
        'BranchID',
        'JobNo',
        'JobDetail',
        'JobDate',
        'JobDueDate',
        'PartyID',
        'UserID',
    ];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'BranchID', 'BranchID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'id');
    }

    public function attendanceDetails()
    {
        return $this->hasMany(AttendanceDetail::class, 'job_id', 'JobID');
    }
}
