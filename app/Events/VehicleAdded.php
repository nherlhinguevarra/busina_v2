<?php

namespace App\Events;

use App\Models\Vehicle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class VehicleAdded implements ShouldBroadcastNow
{
    public $vehicle;

    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function broadcastOn()
    {
        return new Channel('vehicles');
    }

    public function broadcastWith()
    {
        return [
            'message' => 'A new vehicle with plate number ' . $this->vehicle->plate_no . ' has been added.',
            'url' => route('pa_details', ['id' => $this->vehicle->id]),
        ];
    }
}

