<?php

use App\Http\Controllers\OtpRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;

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
    Route::get('roles/get-data', [RoleController::class, 'getData'])->name('roles.get-data');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');

    Route::get('/otp', [OtpRequestController::class, 'index'])->name('otp');
    Route::post('/send-otp', [OtpRequestController::class, 'sendOtp'])->name('sendOtp');
    Route::get('/otp/verify/{userId}', [OtpRequestController::class, 'showVerificationForm'])->name('otp.verify');
    Route::post('/otp/verify/{userId}', [OtpRequestController::class, 'verifyOtp'])->name('otp.verify.submit');
});

require __DIR__.'/auth.php';
