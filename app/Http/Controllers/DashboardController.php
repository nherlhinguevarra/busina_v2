<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Violation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        // Fetch transactions with pending claiming status for the new table
        $pendingPickups = Transaction::with(['vehicle.vehicle_owner'])
                        ->where('claiming_status_id', 1)
                        ->paginate($perPage);

        $unsettledViolations = Violation::with(['violation_type'])
        ->where('remarks', 'Not been settled')
        ->paginate($perPage);

        return view('dashboard', compact('pendingPickups', 'unsettledViolations'));
    }
}
