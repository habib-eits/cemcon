<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryService {


    public function isSalaryCreated(Request $request)
    {
        return Salary::where('branch_id', $request->branch_id)
        ->whereYear('salary_month', Carbon::parse($request->salary_month)->year)
        ->whereMonth('salary_month', Carbon::parse($request->salary_month)->month)
        ->exists();
    }


    public function basicHourlyRate($baseSalary,Salary $salary)
    {
        $days = $salary->working_days;
        $hours = $salary->office_hours_per_day;
        $hourlyRate = $baseSalary / $days / $hours;
        
        return round($hourlyRate,6);
    }
    public function overtimeHourlyRate($baseSalary,Salary $salary)
    {
        $days = 30;
        $rate = $salary->overtime_working_day_rate;
        $hours = $salary->office_hours_per_day;
        $hourlyRate = ($baseSalary / $days / $hours) * $rate;
        return round($hourlyRate,6);
    }
    public function holidayOvertimeHourlyRate($baseSalary,Salary $salary)
    {
        $days = 30;
        $rate = $salary->overtime_holiday_rate;
        $hours = $salary->office_hours_per_day;

       $hourlyRate = ($baseSalary / $days / $hours) * $rate;

        return round($hourlyRate,6);
    }

    public function getEmployeeMonthlyAttendanceTotals($employee,$period)
    {
        return DB::table('attendance_details')
            ->selectRaw('
                SUM(worked_hours) as basic_worked_hours,
                SUM(CASE WHEN is_holiday = 0 THEN overtime ELSE 0 END) as overtime_hours,
                SUM(CASE WHEN is_holiday = 1 THEN overtime ELSE 0 END) as holiday_overtime_hours
            ')
        ->where('employee_id', $employee->EmployeeID)
        ->whereMonth('date', $period->month)
        ->whereYear('date', $period->year)
        ->first();
    }

    public function getEmployeeSalaryCalculations($employee, $salary, $attendanceSummary)
    {
        $basicHourlyRate = $this->basicHourlyRate($employee->Salary, $salary);
        $overtimeHourlyRate = $this->overtimeHourlyRate($employee->Salary, $salary);
        $holidayOvertimeHourlyRate = $this->holidayOvertimeHourlyRate($employee->Salary, $salary);

        $basicTotal = round($basicHourlyRate * $attendanceSummary->basic_worked_hours, 2);
        $overtimeTotal = round($overtimeHourlyRate * $attendanceSummary->overtime_hours, 2);
        $holidayOvertimeTotal = round(
            $holidayOvertimeHourlyRate * $attendanceSummary->holiday_overtime_hours,
            2
        );

        $advancePaid = 0;
        $grossSalary = $basicTotal + $overtimeTotal + $holidayOvertimeTotal - $advancePaid;

        return [
            'salary_base_amount' => $employee->Salary,
            'salary_base_per_day' => round($employee->Salary / $salary->working_days, 2),

            'basic_worked_hours' => $attendanceSummary->basic_worked_hours,
            'overtime_hours' => $attendanceSummary->overtime_hours,
            'holiday_overtime_hours' => $attendanceSummary->holiday_overtime_hours,

            'basic_hourly_rate' => $basicHourlyRate,
            'overtime_hourly_rate' => $overtimeHourlyRate,
            'holiday_overtime_hourly_rate' => $holidayOvertimeHourlyRate,

            'basic_total' => $basicTotal,
            'overtime_total' => $overtimeTotal,
            'holiday_overtime_total' => $holidayOvertimeTotal,

            'advance_paid' => $advancePaid,
            'gross_salary' => $grossSalary,
            'net_salary' => $grossSalary,
        ];
    }


    
}
