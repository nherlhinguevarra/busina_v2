<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Violation;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function checkNewEntries()
    {
        // Check for vehicles added in the last 5 minutes
        $newVehicles = Vehicle::where('created_at', '>=', Carbon::now()->subMinutes(5))->count();
        
        // Check for violations added in the last 5 minutes
        $newViolations = Violation::where('created_at', '>=', Carbon::now()->subMinutes(5))->count();
        
        // Return the result as a JSON response
        return response()->json([
            'newVehicles' => $newVehicles > 0,
            'newViolations' => $newViolations > 0,
        ]);
    }
}
