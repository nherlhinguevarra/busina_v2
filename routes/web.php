<?php

use App\Http\Controllers\AllUsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PendingPickupController;
use App\Http\Controllers\RegisteredVehiclesController;
use App\Http\Controllers\ReportedViolationsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UnsettledViolationsController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/pending_applications', function () {
        return view('pending_applications');
    })->name('pending_applications');

    Route::get('/registered_vehicles', function () {
        return view('registered_vehicles');
    })->name('registered_vehicles');

    Route::get('/reported_violations', function () {
        return view('reported_violations');
    })->name('reported_violations');

    Route::get('/all_users', function () {
        return view('all_users');
    })->name('all_users');

    Route::get('/guidelines', function () {
        return view('guidelines');
    })->name('guidelines');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pending_applications', [DataTableController::class, 'index'])->name('pending_applications');
    Route::get('/pa_details/{id}', [DataTableController::class, 'showDetails'])->name('pa_details');
    Route::get('/export-all-details-csv', [DataTableController::class, 'exportAllDetailsToCSV'])->name('exportAllDetailsToCSV');

    Route::get('/registered_vehicles', [RegisteredVehiclesController::class, 'index'])->name('registered_vehicles');
    Route::get('/reg_details/{id}', [RegisteredVehiclesController::class, 'showDetails'])->name('reg_details');
    Route::get('/export-all-details-csv', [RegisteredVehiclesController::class, 'exportAllDetailsToCSV'])->name('exportAllDetailsToCSV');

    Route::get('/reported_violations', [ReportedViolationsController::class, 'index'])->name('reported_violations');
    Route::get('/rv_details/{id}', [ReportedViolationsController::class, 'showDetails'])->name('rv_details');
    Route::get('/export-all-details-csv', [ReportedViolationsController::class, 'exportAllDetailsToCSV'])->name('exportAllDetailsToCSV');

    Route::get('/all_users', [AllUsersController::class, 'index'])->name('all_users');
    Route::get('/au_details/{id}', [AllUsersController::class, 'showDetails'])->name('au_details');
    Route::get('/export-all-details-csv', [AllUsersController::class, 'exportAllDetailsToCSV'])->name('exportAllDetailsToCSV');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login'); // Login form
Route::post('/', [LoginController::class, 'login']); // Handle login

Route::get('/forgot_pass', [ForgotPasswordController::class, 'showForm'])->name('password.request'); // Forgot password form
Route::post('/forgot_pass', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email'); // Send reset code

Route::get('/pass_emailed', function (Request $request) {
    if (!$request->session()->has('reset_authorized')) {
        return redirect()->route('password.request');
    }

    // Clear the session variable after accessing the route
    $request->session()->forget('reset_authorized');
    
    return view('pass_emailed');
})->name('pass_emailed');

// Routes for password reset
Route::get('/reset_new_pass/{emp_no}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset_new_pass_with_emp_no');
Route::get('/reset_new_pass', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset_new_pass'); // URL without emp_no
Route::post('/update_password', [ResetPasswordController::class, 'updatePassword'])->name('update_password');

Route::get('/updated_pass_result', function () {
    // Check if the password update session variable is set
    if (!Session::has('password_updated')) {
        return redirect()->route('password.request');
    }

    // Clear the session variable after accessing the route
    Session::forget('password_updated');
    
    return view('updated_pass_result');
})->name('updated_pass_result'); // Password updated confirmation

Route::get('/email', function () {
    return view('email');
})->name('email'); // Password reset link emailed confirmation