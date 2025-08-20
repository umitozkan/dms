<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DubbingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Data endpoint for server-side DataTables (must be before resource to avoid conflict)
Route::get('incomes/datatable', [IncomeController::class, 'datatable'])
    ->middleware('auth')
    ->name('incomes.datatable');

// Resource routes
Route::resource('companies', CompanyController::class);
Route::resource('shows', ShowController::class);
Route::resource('languages', LanguageController::class);
Route::resource('studios', StudioController::class);
Route::resource('dubbings', DubbingController::class);
Route::resource('materials', MaterialController::class);
Route::resource('incomes', IncomeController::class)->middleware('auth');
Route::resource('users', UserController::class)
    ->except(['show'])
    ->middleware('auth');

require __DIR__.'/auth.php';
