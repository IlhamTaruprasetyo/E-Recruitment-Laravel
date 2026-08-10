<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Actions\Logout;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\TestCategoryController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestEvaluationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Group Routes (Protected by auth & RoleMiddleware for 'admin')
Route::middleware(['auth', 'verified', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('dashboard', 'livewire.admin.dashboard.index')->name('dashboard');
        // Recruitment Management
        Route::view('jobs', 'livewire.admin.jobs.index')->name('job');
        Route::post('jobs', [JobController::class, 'store'])->name('job.store');
        Route::put('jobs/{id}', [JobController::class, 'update'])->name('job.update');
        Route::delete('jobs/{id}', [JobController::class, 'destroy'])->name('job.destroy');

        Route::view('applicants', 'livewire.admin.applicants.index')->name('application');
        Route::put('applicants/{id}', [JobApplicationController::class, 'update'])->name('application.update');

        // Data Master Company
        Route::view('companies', 'livewire.admin.company.index')->name('company');
        Route::post('companies', [CompanyController::class, 'store'])->name('company.store');
        Route::put('companies/{id}', [CompanyController::class, 'update'])->name('company.update');
        Route::delete('companies/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
        
        // Data Master Department
        Route::view('departments', 'livewire.admin.department.index')->name('department');
        Route::post('departments', [DepartmentController::class, 'store'])->name('department.store');
        Route::put('departments/{id}', [DepartmentController::class, 'update'])->name('department.update');
        Route::delete('departments/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
        
        // Data Master Major / Jurusan
        Route::view('majors', 'livewire.admin.major.index')->name('major');
        Route::post('majors', [MajorController::class, 'store'])->name('major.store');
        Route::put('majors/{id}', [MajorController::class, 'update'])->name('major.update');
        Route::delete('majors/{id}', [MajorController::class, 'destroy'])->name('major.destroy');
        
        // Data Master Degree / Tingkat Pendidikan
        Route::view('degrees', 'livewire.admin.degree.index')->name('degree');
        Route::post('degrees', [DegreeController::class, 'store'])->name('degree.store');
        Route::put('degrees/{id}', [DegreeController::class, 'update'])->name('degree.update');
        Route::delete('degrees/{id}', [DegreeController::class, 'destroy'])->name('degree.destroy');
        
        // Data Master Test Category / Kategori Soal
        Route::view('test-categories', 'livewire.admin.test-category.index')->name('test_category');
        Route::post('test-categories', [TestCategoryController::class, 'store'])->name('test_category.store');
        Route::put('test-categories/{id}', [TestCategoryController::class, 'update'])->name('test_category.update');
        Route::delete('test-categories/{id}', [TestCategoryController::class, 'destroy'])->name('test_category.destroy');

        // Data Master Question Bank / Bank Soal
        Route::view('question-banks', 'livewire.admin.question-bank.index')->name('question_bank');
        Route::post('question-banks', [QuestionBankController::class, 'store'])->name('question_bank.store');
        Route::post('question-banks/import', [QuestionBankController::class, 'import'])->name('question_bank.import');
        Route::get('question-banks/download-template', [QuestionBankController::class, 'downloadTemplate'])->name('question_bank.download_template');
        Route::put('question-banks/{id}', [QuestionBankController::class, 'update'])->name('question_bank.update');
        Route::delete('question-banks/{id}', [QuestionBankController::class, 'destroy'])->name('question_bank.destroy');
        
        // Recruitment Tests / Merakit Paket Ujian
        Route::view('tests', 'livewire.admin.test.index')->name('test');
        Route::post('tests', [TestController::class, 'store'])->name('test.store');
        Route::put('tests/{id}', [TestController::class, 'update'])->name('test.update');
        Route::delete('tests/{id}', [TestController::class, 'destroy'])->name('test.destroy');
        
        // Evaluation & Essay Grading / Evaluasi Hasil & Nilai Ujian
        Route::view('test-evaluations', 'livewire.admin.test-evaluation.index')->name('test_evaluation');
        Route::put('test-evaluations/{id}/grade', [TestEvaluationController::class, 'updateGrade'])->name('test_evaluation.grade');
        
        // Candidate Database
        Route::view('candidates', 'livewire.admin.candidates.index')->name('candidate');
    });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
