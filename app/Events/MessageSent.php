<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Construct the event.
     * 
     * @param Message $message
     */
    public function __construct(public Message $message)
    {
        // 
    }

    /**
     * Get the channels the event should broadcast on.
     * 
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel(sprintf('chats.conversation.%s', $this->message->conversation_id)),
        ];
    }

    /**
     * Get the data to broadcast.
     * 
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return $this->message
            ->toArray();
    }

    /**
     * Get the broadcast name.
     * 
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat.message.sent';
    }
}

