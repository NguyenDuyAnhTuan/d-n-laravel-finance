<?php
// filepath: c:\Users\Admin\Project\atProject\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\JarConfigController;

// Income APIs
Route::resource('income', IncomeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

// Expense APIs
Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

// Jar Config APIs
Route::resource('jar-configs', JarConfigController::class)->only(['index', 'store', 'show', 'update', 'destroy']);