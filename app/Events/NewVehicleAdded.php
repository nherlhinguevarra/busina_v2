<?php

namespace App\Events;

use App\Models\Vehicle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewVehicleAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function broadcastOn()
    {
        return new Channel('database-changes');
    }

    public function broadcastAs()
    {
        return 'new-vehicle';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->vehicle->id,
            'plate_number' => $this->vehicle->plate_number,
            'message' => 'New vehicle has been registered'
        ];
    }
}
