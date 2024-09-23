<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para el CRUD de empleados
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'indexView'])->name('employees.index.view');
    Route::get('/create', [EmployeeController::class, 'createView'])->name('employees.create.view');
    Route::get('/{id}/edit', [EmployeeController::class, 'editView'])->name('employees.edit.view');
    Route::get('/{id}', [EmployeeController::class, 'showView'])->name('employees.show.view');
});

Route::resource('roles', RoleController::class);
Route::resource('departments', DepartmentController::class);
