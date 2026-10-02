<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AmaliahSync Web Routes
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return redirect(app(AuthController::class)->redirectPathForUser($request->user()));
    }

    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Unified Attendance Shortcut (Directs to role-specific attendance page)
Route::middleware('auth')->get('/attendance', function (Request $request) {
    $user = $request->user();
    if ($user->isStudent()) {
        return redirect()->route('student.attendance.index');
    }
    if ($user->isSupervisor()) {
        return redirect()->route('supervisor.attendances.index');
    }

    return redirect()->route('admin.dashboard');
})->name('attendance.index');

// 👑 Administrator Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/places', function () {
        return redirect()->route('admin.dashboard');
    })->name('places.index');

    Route::get('/students', function () {
        return redirect()->route('admin.dashboard');
    })->name('students.index');

    Route::get('/supervisors', function () {
        return redirect()->route('admin.dashboard');
    })->name('supervisors.index');
});

// 👨‍🏫 Guru Pembimbing (Supervisor) Routes
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('dashboard');

    Route::get('/attendances', function () {
        return redirect()->route('supervisor.dashboard');
    })->name('attendances.index');

    Route::get('/logs', function () {
        return redirect()->route('supervisor.dashboard');
    })->name('logs.index');
});

// 🎓 Siswa PKL (Student) Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');

    Route::get('/attendance', function () {
        return redirect()->route('student.dashboard');
    })->name('attendance.index');

    Route::get('/logs', function () {
        return redirect()->route('student.dashboard');
    })->name('logs.index');

    Route::get('/profile', function () {
        return redirect()->route('student.dashboard');
    })->name('profile');
});
