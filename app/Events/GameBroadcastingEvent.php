<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public array $gameData)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('game');
    }

    public function broadcastAs(): string
    {
        return 'game';
    }

    public function broadcastWith(): array
    {
        $userdata = [];
        if (auth()->user() !== null) {
            $userdata = [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
            ];
        }

        return [
            'data' => array_merge($userdata, $this->gameData ?? []),
        ];
    }
}
