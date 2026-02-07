<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashbordcontroller;
use App\Http\Controllers\Companycontroller;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\JobCategorycontroller;
use App\Http\Controllers\JobVacancycontroller;
use App\Http\Controllers\JobApplicatoncontroller;




Route::middleware('auth')->group(function () {
    Route::get('/', [Dashbordcontroller::class, 'index'])->name('dashboard');
    
    Route::resource('companies', Companycontroller::class);
    Route::put('/companies/{id}/restore', [Companycontroller::class, 'restore'])->name('companies.restore');
    
    Route::resource('users', Usercontroller::class);

    Route::resource('job-category', JobCategorycontroller::class);
    Route::put('/job-category/{id}/restore', [JobCategorycontroller::class, 'restore'])->name('job-category.restore');

    Route::resource('job-vacancy', JobVacancycontroller::class);

    Route::resource('job-application', JobApplicatoncontroller::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
