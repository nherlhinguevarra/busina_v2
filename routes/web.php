<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AllUsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardStats;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PendingPickupController;
use App\Http\Controllers\RegisteredVehiclesController;
use App\Http\Controllers\ReportedViolationsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SettleViolationController;
use App\Http\Controllers\UnsettledViolationsController;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NotificationController;
use App\Models\Vehicle;
use App\Models\Violation;

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

    Route::get('/account', [AccountController::class, 'show'])->name('account');
    Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/change-password', [AccountController::class, 'changePassword'])->name('changePassword');
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/dashboard-tables', [DashboardController::class, 'index'])->name('dashboard.tables');
    // Route::get('/dashboard-stats', [DashboardStats::class, 'index'])->name('dashboard.stats');

    // Route::get('/dashboard', function (Request $request) {
    //     // Fetch data from both controllers
    //     $tableController = app()->make('App\Http\Controllers\DashboardController');
    //     $statsController = app()->make('App\Http\Controllers\DashboardStats');
    
    //     // Get the data for tables
    //     $tablesData = $tableController->index($request)->getData();
    
    //     // Get the data for stats
    //     $statsData = $statsController->index($request)->getData();
    
    //     // Merge both data sets
    //     $data = array_merge($tablesData, $statsData);
    
    //     return view('dashboard', $data);
    // })->name('dashboard');

    Route::get('/pending_applications', [DataTableController::class, 'index'])->name('pending_applications');
    Route::get('/pa_details/{id}', [DataTableController::class, 'showDetails'])->name('pa_details');
    Route::get('/export-all-app-details-csv', [DataTableController::class, 'exportAllAppDetailsToCSV'])->name('exportAllAppDetailsToCSV');

    Route::get('/registered_vehicles', [RegisteredVehiclesController::class, 'index'])->name('registered_vehicles');
    Route::get('/reg_details/{id}', [RegisteredVehiclesController::class, 'showDetails'])->name('reg_details');
    Route::get('/export-all-reg-details-csv', [RegisteredVehiclesController::class, 'exportAllRegDetailsToCSV'])->name('exportAllRegDetailsToCSV');
    Route::post('/update-claiming-status', [RegisteredVehiclesController::class, 'updateClaimingStatus']);

    Route::get('/reported_violations', [ReportedViolationsController::class, 'index'])->name('reported_violations');
    Route::get('/rv_details/{id}', [ReportedViolationsController::class, 'showDetails'])->name('rv_details');
    Route::get('/export-all-vio-details-csv', [ReportedViolationsController::class, 'exportAllVioDetailsToCSV'])->name('exportAllVioDetailsToCSV');

    Route::get('/all_users', [AllUsersController::class, 'index'])->name('all_users');
    Route::get('/au_details/{id}', [AllUsersController::class, 'showDetails'])->name('au_details');
    Route::get('/export-all-user-details-csv', [AllUsersController::class, 'exportAllUserDetailsToCSV'])->name('exportAllUserDetailsToCSV');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/settle-violation/store', [ReportedViolationsController::class, 'store'])->name('settle_violation.store');

    Route::post('/save-document-approval/{vehicleOwnerId}', [DataTableController::class, 'saveDocumentApproval'])->name('save.document.approval');

    Route::get('/check-new-entries', function() {
        $newVehicles = Vehicle::with('vehicle_owner') // Ensure relationship is loaded
            ->where('created_at', '>', now()->subMinutes(60))
            ->get();
    
        $newViolations = Violation::where('created_at', '>', now()->subMinutes(60))->get();
    
        return response()->json([
            'newVehicles' => $newVehicles,
            'newViolations' => $newViolations
        ]);
    });
    
    

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