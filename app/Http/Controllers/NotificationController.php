<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Violation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    // public function checkNewEntries()
    // {
    //     // Check for vehicles added in the last 5 minutes
    //     $newVehicles = Vehicle::where('created_at', '>=', Carbon::now()->subMinutes(5))->count();
        
    //     // Check for violations added in the last 5 minutes
    //     $newViolations = Violation::where('created_at', '>=', Carbon::now()->subMinutes(5))->count();
        
    //     // Return the result as a JSON response
    //     return response()->json([
    //         'newVehicles' => $newVehicles > 0,
    //         'newViolations' => $newViolations > 0,
    //     ]);
    // }

    public function checkNewEntries()
    {
        try {
            // Query recent entries
            $newVehicles = DB::table('vehicle')
                ->where('created_at', '>', now()->subSeconds(10))
                ->get();
    
            $newViolations = DB::table('violation')
                ->where('created_at', '>', now()->subSeconds(10))
                ->get();
    
            // Return results
            return response()->json([
                'newVehicles' => $newVehicles,
                'newViolations' => $newViolations,
            ]);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching new entries: ' . $e->getMessage());
            
            // Return an error response with more details
            return response()->json(['error' => 'Failed to fetch new entries', 'message' => $e->getMessage()], 500);
        }
    }

    
}
