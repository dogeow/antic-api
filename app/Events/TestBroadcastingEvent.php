<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $isRobot;

    /**
     * Create a new event instance.
     *
     * @param  string  $message
     * @param  bool  $isRobot
     */
    public function __construct($message, $isRobot = false)
    {
        $this->message = $message;
        $this->isRobot = $isRobot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }

    public function broadcastAs()
    {
        return 'chat';
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                'id' => $this->isRobot ? 0 : auth()->user()->id,
                'name' => $this->isRobot ? "机器人" : auth()->user()->name,
                'message' => $this->message,
            ],
        ];
    }
}
