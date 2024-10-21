<?php

namespace App\Http\Controllers;

use App\Models\Settle_violation;
use App\Models\Transaction;
use App\Models\Vehicle;
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

    public function getVehicleAndViolationData()
    {
        // Get vehicles registered per week
        $vehiclesPerWeek = Vehicle::selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
            ->groupBy('week')
            ->get();

        // Get vehicles registered per month
        $vehiclesPerMonth = Vehicle::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get();

        // Get violations reported per week
        $violationsPerWeek = Violation::selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
            ->groupBy('week')
            ->get();

        // Get violations reported per month
        $violationsPerMonth = Violation::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get();

        return response()->json([
            'vehiclesPerWeek' => $vehiclesPerWeek,
            'vehiclesPerMonth' => $vehiclesPerMonth,
            'violationsPerWeek' => $violationsPerWeek,
            'violationsPerMonth' => $violationsPerMonth,
        ]);
    }


}
