<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpRequestController;
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
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}/update', [RoleController::class, 'update'])->name('roles.update');


    Route::get('/society', [SocietyController::class, 'index'])->name('society.index');
    Route::get('/society/get-data', [SocietyController::class, 'getData'])->name('society.get-data');
    Route::get('/society/create', [SocietyController::class, 'create'])->name('society.create');
    Route::post('/society/store', [SocietyController::class, 'store'])->name('society.store');
    Route::delete('/society/{society}', [SocietyController::class, 'destroy'])->name('society.destroy');
    Route::get('/society/{society}/edit', [SocietyController::class, 'edit'])->name('society.edit');
    Route::put('/society/{society}/update', [SocietyController::class, 'update'])->name('society.update');


});



    Route::get('/society/dashboard', [DashboardController::class, 'index'])->name('society.dashboard');
    Route::post('/society/logout', [DashboardController::class, 'logout'])->name('society.logout');

    Route::get('/society/login', [OtpRequestController::class, 'index'])->name('otpRequest');
    Route::post('/send-otp', [OtpRequestController::class, 'sendOtp'])->name('sendOtp');
    Route::get('/society/login/verify/{societyId}', [OtpRequestController::class, 'showVerificationForm'])->name('otp.verify');
    Route::post('/society/login/verify/{societyId}', [OtpRequestController::class, 'verifyOtp'])->name('otp.verify.submit');


    Route::get('/society/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/society/members/get-data', [MemberController::class, 'getData'])->name('members.get-data');
    Route::get('/society/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/society/members/import', [MemberController::class, 'memberImport'])->name('members.import');
    Route::delete('/society/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::put('/member/{id}/status', [MemberController::class, 'updateStatus'])->name('members.update-status');



require __DIR__.'/auth.php';
