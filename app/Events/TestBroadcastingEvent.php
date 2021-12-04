<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;

    public bool $isRobot;

    /**
     * Create a new event instance.
     *
     * @param  string  $message
     * @param  bool  $isRobot
     */
    public function __construct(string $message, bool $isRobot = false)
    {
        $this->message = $message;
        $this->isRobot = $isRobot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('chat');
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                'id' => $this->isRobot ? 0 : auth()->user()->id,
                'name' => $this->isRobot ? '机器人' : auth()->user()->name,
                'message' => $this->message,
            ],
        ];
    }
}
