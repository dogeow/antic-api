<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $gameData;

    /**
     * Create a new event instance.
     */
    public function __construct(array $gameData)
    {
        $this->gameData = $gameData;
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
        if (auth()->user()) {
            $userdata = [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
            ];
        }

        return [
            'data' => array_merge($userdata, $this->gameData),
        ];
    }
}
