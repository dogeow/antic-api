<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatBroadcastingEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public string $message, public bool $isRobot = false)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('chat');
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }

    public function broadcastWith(): array
    {
        if (!auth()->check()) {
            abort(401, '未经授权无法执行此操作');
        }

        return [
            'data' => [
                'id' => $this->isRobot ? 0 : auth()->user()->id,
                'name' => $this->isRobot ? '机器人' : auth()->user()->name,
                'message' => $this->message,
            ],
        ];
    }
}
