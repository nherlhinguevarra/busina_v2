<?php

namespace App\Http\Controllers;

use App\Models\Settle_violation;
use App\Models\Transaction;
use App\Models\Violation;
use Illuminate\Http\Request;

class DashboardStats extends Controller
{
    public function index()
    {
        // Count pending applications
        $pendingApplications = Transaction::where('claiming_status_id', 0)->count();

        // Count registered vehicles with issued_date in the current month
        $registeredVehicles = Transaction::whereIn('claiming_status_id', [1, 2])
            ->whereMonth('issued_date', now()->month)
            ->whereYear('issued_date', now()->year)
            ->count();

        // Count violations to be reviewed
        $violationsToBeReviewed = Settle_violation::whereNull('resolve_at')
            ->whereNull('updated_at')
            ->count();

        // Count reported violations this month
        $reportedViolationsThisMonth = Violation::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard', compact(
            'pendingApplications',
            'registeredVehicles',
            'violationsToBeReviewed',
            'reportedViolationsThisMonth'
        ));
    }
}
