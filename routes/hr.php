<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\EmployeeDetailController;
use App\Http\Controllers\Hr\EmployeeLetterController;
// Add more controllers as you create them

/*
|--------------------------------------------------------------------------
| HR / Employee Routes
|--------------------------------------------------------------------------
|
| All routes related to employees, their details, salary, letters, leave, etc.
| Protected by authentication and role checks via middleware.
|
*/

Route::group(['middleware' => ['CheckAdmin']], function () {

    //Employee routes
    Route::resource('employees', EmployeeController::class);
    Route::get('employee_ajax', [EmployeeController::class, 'employee_ajax'])->name('employee.ajax');

    //Employee Allownaces routes
    Route::get('/employee/{employeeId}/salary', [EmployeeDetailController::class, 'salary'])->name('employee.salary');
    Route::post('/employee/{employeeId}/allowance/save', [EmployeeDetailController::class, 'allowanceSave'])->name('employee.allowance.save');
    Route::delete('/allowance/delete/{allowanceId}', [EmployeeDetailController::class, 'allowanceDelete'])->name('employee.allowance.delete');
    Route::get('/employee/{employeeId}/salary-slip/{salaryId}', [EmployeeDetailController::class, 'empSalarySlip'])->name('employee.salary-slip');

    // Employee Letters Module
    Route::get('/employee/{employeeId}/letters', [EmployeeLetterController::class, 'index'])
        ->name('employee.letters');

    Route::get('/employee/{employeeId}/letters/warnings', [EmployeeLetterController::class, 'warnings'])
        ->name('employee.letters.warnings');

    Route::get('/employee/{employeeId}/letters/preview', [EmployeeLetterController::class, 'preview'])
        ->name('employee.letters.preview');

    Route::post('/employee/{employeeId}/letters', [EmployeeLetterController::class, 'store'])
        ->name('employee.letters.store');

    Route::get('/employee/{employeeId}/letters/{issueLetterId}/edit', [EmployeeLetterController::class, 'edit'])
        ->name('employee.letters.edit');

    Route::put('/employee/{employeeId}/letters/{issueLetterId}', [EmployeeLetterController::class, 'update'])
        ->name('employee.letters.update');

    Route::delete('/employee/{employeeId}/letters/{issueLetterId}', [EmployeeLetterController::class, 'destroy'])
        ->name('employee.letters.delete');

    Route::get('/employee/{employeeId}/letters/{issueLetterId}/print', [EmployeeLetterController::class, 'print'])
        ->name('employee.letters.print');

    //Attendance Routes
    Route::resource('attendances', AttendanceController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('attendances/view/{date}', [AttendanceController::class, 'show'])->name('attendances.show');
});
