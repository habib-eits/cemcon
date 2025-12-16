<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;


    public static function generateExpenseNo()
    {
        $expenseNo = DB::table('expense_master')
        ->selectRaw("
            LPAD(
                COALESCE(
                    MAX(CAST(SUBSTRING_INDEX(ExpenseNo, '-', -1) AS UNSIGNED)),
                    0
                ) + 1,
                5,
                '0'
            ) AS vhno
        ")
        ->where('ExpenseNo', 'like', 'EXP-%')
        ->value('vhno');

        return 'EXP-'.$expenseNo;

    }
}
