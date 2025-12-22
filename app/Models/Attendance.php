<?php

namespace App\Models;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

     protected $fillable = [
        'date',
        'time',
        'user_id',
        'branch_id',
    ];

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
