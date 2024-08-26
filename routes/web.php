<?php

use App\Http\Controllers\AllUsersController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PendingPickupController;
use App\Http\Controllers\RegisteredVehiclesController;
use App\Http\Controllers\ReportedViolationsController;
use App\Http\Controllers\UnsettledViolationsController;

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







