<?php

namespace App\Events;

use App\Models\Violation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewViolationAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $violation;

    public function __construct(Violation $violation)
    {
        $this->violation = $violation;
    }

    public function broadcastOn()
    {
        return new Channel('database-changes');
    }

    public function broadcastAs()
    {
        return 'new-violation';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->violation->id,
            'type' => $this->violation->type,
            'message' => 'New violation has been recorded'
        ];
    }
}
