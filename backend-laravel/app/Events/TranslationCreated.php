<?php

namespace App\Events;

use App\Models\Translation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TranslationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Translation $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->translation->id,
            'translated_text' => $this->translation->translated_text,
            'created_at' => $this->translation->created_at->toISOString(),
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('translations.' . $this->translation->user_id),
        ];
    }
}
