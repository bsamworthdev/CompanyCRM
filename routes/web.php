<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth:sanctum'], function () {
    //Companies
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::post('/companies/create', [CompanyController::class, 'create'])->name('createcompany');
    Route::post('/companies/update/{id}', [CompanyController::class, 'update'])->name('updatecompany');
    Route::post('/companies/delete/{id}', [CompanyController::class, 'delete'])->name('deletecompany');

    //Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/employees/create', [EmployeeController::class, 'create'])->name('createemployee');
    Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('updateemployee');
    Route::post('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('deleteemployee');
});