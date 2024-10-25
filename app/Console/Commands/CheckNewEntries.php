<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Models\Violation;
use App\Events\VehicleAdded;
use App\Events\ViolationAdded;
use Carbon\Carbon;

class CheckNewEntries extends Command
{
    // The name and signature of the command.
    protected $signature = 'check:new-entries';

    // The console command description.
    protected $description = 'Check for newly added vehicles and violations, then broadcast real-time notifications';

    // Execute the console command.
    public function handle()
    {
        $this->info('Checking for new entries in vehicle and violation tables...');

        // Fetch new vehicles added in the last minute
        $newVehicles = Vehicle::where('created_at', '>=', Carbon::now()->subMinute())->get();
        
        if ($newVehicles->isNotEmpty()) {
            foreach ($newVehicles as $vehicle) {
                // Broadcast the event for each new vehicle
                broadcast(new VehicleAdded($vehicle));
                $this->info('Broadcasted new vehicle with plate number: ' . $vehicle->plate_no);
            }
        } else {
            $this->info('No new vehicles found.');
        }

        // Fetch new violations added in the last minute
        $newViolations = Violation::where('created_at', '>=', Carbon::now()->subMinute())->get();

        if ($newViolations->isNotEmpty()) {
            foreach ($newViolations as $violation) {
                // Broadcast the event for each new violation
                broadcast(new ViolationAdded($violation));
                $this->info('Broadcasted new violation for vehicle with plate number: ' . $violation->plate_no);
            }
        } else {
            $this->info('No new violations found.');
        }

        return 0;
    }
}
