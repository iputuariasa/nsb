<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeadOfficeController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\OrganizationStructureController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['admin'])->group(function(){
    Route::resource('users', UserController::class);
    Route::resource('headOffices', HeadOfficeController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('kiosks', KioskController::class);
    Route::get('/office_networks', [OrganizationStructureController::class, 'index'])
     ->name('office_networks');
});

Route::middleware(['allow.admin.credit'])->group(function(){
    Route::resource('pillars', PillarController::class);
    Route::resource('loans', LoanController::class);
});