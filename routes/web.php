<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OtpRequestController;
use App\Http\Controllers\Society\MemberController;
use App\Http\Controllers\Society\DashboardController;
use App\Http\Controllers\SuperAdmin\SocietyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/get-data', [RoleController::class, 'getData'])->name('roles.get-data');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');

    Route::get('/society', [SocietyController::class, 'index'])->name('society.index');
    Route::get('/society/get-data', [SocietyController::class, 'getData'])->name('society.get-data');
    Route::get('/society/create', [SocietyController::class, 'create'])->name('society.create');
    Route::post('/society/store', [SocietyController::class, 'store'])->name('society.store');

});



    Route::get('/otp-login', [OtpRequestController::class, 'index'])->name('otpRequest');
    Route::post('/send-otp', [OtpRequestController::class, 'sendOtp'])->name('sendOtp');
    Route::get('/otp-login/verify/{societyId}', [OtpRequestController::class, 'showVerificationForm'])->name('otp.verify');
    Route::post('/otp-login/verify/{societyId}', [OtpRequestController::class, 'verifyOtp'])->name('otp.verify.submit');

    Route::get('/society/dashboard', [DashboardController::class, 'index'])->name('society.dashboard');
    Route::post('/society/logout', [DashboardController::class, 'logout'])->name('society.logout');

    Route::get('/society/member', [MemberController::class, 'index'])->name('member.index');


require __DIR__.'/auth.php';
