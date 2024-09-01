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
        $perPage = 10;

        // Fetch transactions with pending claiming status
        $pendingPickups = Transaction::with(['vehicle.vehicle_owner'])
                        ->where('claiming_status_id', 1)
                        ->paginate($perPage);

        // Fetch unsettled violations
        $unsettledViolations = Violation::with(['violation_type'])
                        ->where('remarks', 'Not been settled')
                        ->paginate($perPage);

        // Statistics
        $pendingApplications = Transaction::where('claiming_status_id', 0)->count();
        $registeredVehicles = Transaction::with(['registration_no'])
                            ->whereMonth('issued_date', now()->month)
                            ->whereYear('issued_date', now()->year)
                            ->count();
        $violationsToBeReviewed = Violation::whereNotIn('id', function ($query) {
                $query->select('violation_id')
                    ->from('settle_violation');
        })
        ->where('remarks', 'Not been settled')  // Additional filtering if needed
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
