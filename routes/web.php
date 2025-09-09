<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\GuidanceActivityController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\GuidedStudentController;
use App\Http\Controllers\HeadOfDepartementController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\PrintExamApprovalController;
use App\Http\Controllers\PrintGuidanceHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestExamResultController;
use App\Http\Controllers\SetGuidanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(!Auth::check()) {
        return view('auth.login');
    } elseif (Auth::user()->role == 'student') {
        return redirect()->route('dashboard.student');
    } elseif (Auth::user()->role == 'lecturer') {
        return redirect()->route('dashboard.lecturer');
    } elseif (Auth::user()->role == 'hod') {
        return redirect()->route('dashboard.hod');
    } elseif (Auth::user()->role == 'admin'){
        return redirect()->route('dashboard');
    } else {
        abort(403);
    }
});

Route::middleware('auth')->group(function () {
    // Role-specific dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('can:admin');

    Route::get('/dashboard/student', [DashboardController::class, 'student'])
        ->name('dashboard.student')
        ->middleware('can:student');

    Route::get('/dashboard/lecturer', [DashboardController::class, 'lecturer'])
        ->name('dashboard.lecturer')
        ->middleware('can:lecturer');

    Route::get('/dashboard/hod', [DashboardController::class, 'hod'])
        ->name('dashboard.hod')
        ->middleware('can:HoD');

    // Admin only routes
    Route::middleware('can:admin')->group(function () {
        Route::resource('/dashboard/kelola-user', UserController::class)->names('dashboard.kelola-user');
        Route::resource('/dashboard/dosen', LecturerController::class)->names('dashboard.lecturer');
        Route::resource('/dashboard/mahasiswa', StudentController::class)->names('dashboard.student');
        Route::resource('/dashboard/ketua-jurusan', HeadOfDepartementController::class)->names('dashboard.kajur');
    });

    // Head of Department routes
    Route::middleware('can:HoD')->group(function () {
        // Monitoring
        Route::get('/monitoring/bimbingan', [MonitoringController::class, 'index'])->name('dashboard.monitoring.index');
        Route::get('/monitoring/bimbingan/export', [MonitoringController::class, 'export'])->name('dashboard.monitoring.export');
        Route::get('/monitoring/workload', [MonitoringController::class, 'workload'])->name('dashboard.monitoring.workload');
        Route::get('/monitoring/progress', [MonitoringController::class, 'progress'])->name('dashboard.monitoring.progress');
        Route::get('/aktivitas-bimbingan', [GuidanceActivityController::class, 'index'])->name('dashboard.aktivitas-bimbingan.index');
        Route::get('/aktivitas-bimbingan/{aktivitas_bimbingan}', [GuidanceActivityController::class, 'show'])->name('dashboard.aktivitas-bimbingan.show');
        Route::get('/aktivitas-bimbingan/{aktivitas_bimbingan}/edit', [GuidanceActivityController::class, 'edit'])->name('dashboard.aktivitas-bimbingan.edit');
        Route::put('/aktivitas-bimbingan/{aktivitas_bimbingan}', [GuidanceActivityController::class, 'update'])->name('dashboard.aktivitas-bimbingan.update');

        Route::get('/ujian-hasil', [ExamResultController::class, 'index'])->name('dashboard.ujian-hasil.index');
        Route::post('/ujian-hasil', [ExamResultController::class, 'store'])->name('dashboard.ujian-hasil.store');
        Route::get('/ujian-hasil/{ujian}', [ExamResultController::class, 'show'])->name('dashboard.ujian-hasil.show');
        Route::put('/ujian-hasil/{ujian}', [ExamResultController::class, 'update'])->name('dashboard.ujian-hasil.update');
        Route::delete('/ujian-hasil/{ujian}', [ExamResultController::class, 'destroy'])->name('dashboard.ujian-hasil.destroy');

        Route::get('/pengajuan-ujian-mahasiswa', [RequestExamResultController::class, 'index'])->name('dashboard.pengajuan-ujian-mahasiswa.index');
        Route::get('/cetak-persetujuan-ujian', [PrintExamApprovalController::class, 'index'])->name('dashboard.cetak-persetujuan-ujian');
    });

    // Lecturer routes
    Route::middleware('can:lecturer')->group(function () {
        Route::get('/mahasiswa-bimbingan', [GuidedStudentController::class, 'index'])->name('dashboard.mahasiswa-bimbingan.index');
        Route::get('/mahasiswa-bimbingan/{mahasiswa_bimbingan}', [GuidedStudentController::class, 'show'])->name('dashboard.mahasiswa-bimbingan.show');

        Route::get('/atur-jadwal-bimbingan', [SetGuidanceController::class, 'index'])->name('dashboard.atur-jadwal-bimbingan.index');
        Route::get('/atur-jadwal-bimbingan/{atur_jadwal_bimbingan}', [SetGuidanceController::class, 'show'])->name('dashboard.atur-jadwal-bimbingan.show');
        Route::put('/atur-jadwal-bimbingan/{atur_jadwal_bimbingan}', [SetGuidanceController::class, 'update'])->name('dashboard.atur-jadwal-bimbingan.update');
    });

    // Student routes
    Route::middleware('can:student')->group(function () {
        Route::get('/bimbingan', [GuidanceController::class, 'index'])->name('dashboard.bimbingan.index');

        Route::get('/bimbingan/dosen-pembimbing-1', [GuidanceController::class, 'index'])->name('dashboard.bimbingan-1.index');
        Route::get('/bimbingan/dosen-pembimbing-1/create', [GuidanceController::class, 'create'])->name('dashboard.bimbingan-1.create');
        Route::get('/bimbingan/dosen-pembimbing-1/print', [PrintGuidanceHistoryController::class, 'index'])->name('dashboard.bimbingan-1.print');
        Route::post('/bimbingan/dosen-pembimbing-1', [GuidanceController::class, 'store'])->name('dashboard.bimbingan-1.store');
        Route::get('/bimbingan/dosen-pembimbing-1/{bimbingan}', [GuidanceController::class, 'show'])->name('dashboard.bimbingan-1.show');
        Route::get('/bimbingan/dosen-pembimbing-1/{bimbingan}/edit', [GuidanceController::class, 'edit'])->name('dashboard.bimbingan-1.edit');
        Route::put('/bimbingan/dosen-pembimbing-1/{bimbingan}', [GuidanceController::class, 'update'])->name('dashboard.bimbingan-1.update');
        Route::delete('/bimbingan/dosen-pembimbing-1/{bimbingan}', [GuidanceController::class, 'destroy'])->name('dashboard.bimbingan-1.destroy');

        Route::get('/bimbingan/dosen-pembimbing-2', [GuidanceController::class, 'index'])->name('dashboard.bimbingan-2.index');
        Route::get('/bimbingan/dosen-pembimbing-2/create', [GuidanceController::class, 'create'])->name('dashboard.bimbingan-2.create');
        Route::get('/bimbingan/dosen-pembimbing-2/print', [PrintGuidanceHistoryController::class, 'index'])->name('dashboard.bimbingan-2.print');
        Route::post('/bimbingan/dosen-pembimbing-2', [GuidanceController::class, 'store'])->name('dashboard.bimbingan-2.store');
        Route::get('/bimbingan/dosen-pembimbing-2/{bimbingan}', [GuidanceController::class, 'show'])->name('dashboard.bimbingan-2.show');
        Route::get('/bimbingan/dosen-pembimbing-2/{bimbingan}/edit', [GuidanceController::class, 'edit'])->name('dashboard.bimbingan-2.edit');
        Route::put('/bimbingan/dosen-pembimbing-2/{bimbingan}', [GuidanceController::class, 'update'])->name('dashboard.bimbingan-2.update');
        Route::delete('/bimbingan/dosen-pembimbing-2/{bimbingan}', [GuidanceController::class, 'destroy'])->name('dashboard.bimbingan-2.destroy');

        // Keep backward compatibility for existing student ujian routes
        Route::get('/ujian', [ExamResultController::class, 'index'])->name('dashboard.ujian.index');
        Route::post('/ujian', [ExamResultController::class, 'store'])->name('dashboard.ujian.store');
        Route::get('/ujian/{ujian}', [ExamResultController::class, 'show'])->name('dashboard.ujian.show');
        Route::put('/ujian/{ujian}', [ExamResultController::class, 'update'])->name('dashboard.ujian.update');
        Route::delete('/ujian/{ujian}', [ExamResultController::class, 'destroy'])->name('dashboard.ujian.destroy');
    });

    // Profile routes - accessible by all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/admin', [ProfileController::class, 'update_admin'])->name('profile.update.admin');
    Route::patch('/profile/student', [ProfileController::class, 'update_student'])->name('profile.update.student');
    Route::patch('/profile/lecturer', [ProfileController::class, 'update_lecturer'])->name('profile.update.lecturer');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
