<?php

namespace App\Http\Controllers;

use App\Models\Settle_violation;
use App\Models\Transaction;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $limitPerPage = 5;

    // Fetch transactions with pending claiming status, limited to 5 per page
    $pendingPickups = Transaction::with(['vehicle.vehicle_owner'])
        ->where('claiming_status_id', 2) //2 for claiming
        ->paginate($limitPerPage, ['*'], 'pending-pickups-page');

    // Fetch unsettled violations, limited to 5 per page
    $unsettledViolations = Violation::with(['violation_type'])
        ->where('remarks', 'Not been settled')
        ->paginate($limitPerPage, ['*'], 'unsettled-violations-page');

    // Statistics
    $pendingApplications = Transaction::where('claiming_status_id', 0)->count();
    $registeredVehicles = Transaction::whereMonth('issued_date', now()->month)
        ->whereYear('issued_date', now()->year)
        ->count();
    $violationsToBeReviewed = Violation::whereNotIn('id', function ($query) {
            $query->select('violation_id')
                ->from('settle_violation');
        })
        ->where('remarks', 'Not been settled')
        ->count();
    $reportedViolationsThisMonth = Violation::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    return view('dashboard', compact(
        'pendingPickups',
        'unsettledViolations',
        'pendingApplications',
        'registeredVehicles',
        'violationsToBeReviewed',
        'reportedViolationsThisMonth'
    ));
}


}
