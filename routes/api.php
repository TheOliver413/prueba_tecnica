<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('roles', RoleController::class);
