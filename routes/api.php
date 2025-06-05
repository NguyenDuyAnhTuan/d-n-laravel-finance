<?php
// filepath: c:\Users\Admin\Project\atProject\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;

Route::resource('income', IncomeController::class);
Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
Route::post('/income', [IncomeController::class, 'store'])->name('income.store');