<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Models\Income;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('income')->group(function () {
    Route::get('/', [IncomeController::class, 'index'])->name('income_index');
    Route::post('/', [IncomeController::class, 'store'])->name('income.store');
});

Route::prefix('expense')->group(function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('expense_index');
    Route::post('/', [ExpenseController::class, 'store'])->name('expense.store');
});

Route::prefix('setting')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('setting_index');
    
    Route::post('/update-jar', [SettingController::class, 'updateJars'])
         ->name('settings.updateJars'); 
});