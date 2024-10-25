<?php

namespace App\Events;

use App\Models\Violation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ViolationAdded implements ShouldBroadcastNow
{
    public $violation;

    public function __construct($violation)
    {
        $this->violation = $violation;
    }

    public function broadcastOn()
    {
        return new Channel('violations');
    }

    public function broadcastWith()
    {
        return [
            'message' => 'A new violation with plate number ' . $this->violation->plate_no . ' has been added.',
            'url' => route('rv_details', ['id' => $this->violation->id]),
        ];
    }
}
