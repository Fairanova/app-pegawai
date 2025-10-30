<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

//route untuk default
Route::get('/', function () {
    return view('welcome');
});

//route resource untuk employees
Route::resource('employees', EmployeeController::class);

//route resource untuk department
Route::resource('departments', DepartmentController::class);

//route resource untuk position
Route::resource('positions', PositionController::class);

//route resource untuk attendance - UBAH KE SINGULAR
Route::resource('attendances', AttendanceController::class);

//route resource untuk salary
Route::resource('salaries', SalaryController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');