<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

//route untuk default
Route::get('/', function () {
    return view('welcome');
});

//route resource untuk employees
Route::resource('employees',EmployeeController::class);