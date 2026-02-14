<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashbordcontroller;
use App\Http\Controllers\Companycontroller;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\JobCategorycontroller;
use App\Http\Controllers\JobVacancycontroller;
use App\Http\Controllers\JobApplicatoncontroller;




Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [Dashbordcontroller::class, 'index'])->name('dashboard');
    
       
   
    Route::resource('job-vacancies', JobVacancycontroller::class);
    Route::put('/job-vacancies/{id}/restore', [JobVacancycontroller::class, 'restore'])->name('job-vacancies.restore');

    Route::resource('job-applications', JobApplicatoncontroller::class);
    Route::put('/job-applications/{id}/restore', [JobApplicatoncontroller::class, 'restore'])->name('job-applications.restore');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// company Routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company', [Companycontroller::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [Companycontroller::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [Companycontroller::class, 'update'])->name('my-company.update');


});
// admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('job-category', JobCategorycontroller::class);
    Route::put('/job-category/{id}/restore', [JobCategorycontroller::class, 'restore'])->name('job-category.restore');

    Route::resource('users', Usercontroller::class);
    Route::put('/users/{id}/restore', [Usercontroller::class, 'restore'])->name('users.restore');

    Route::resource('companies', Companycontroller::class);
    Route::put('/companies/{id}/restore', [Companycontroller::class, 'restore'])->name('companies.restore');

});

require __DIR__.'/auth.php';
