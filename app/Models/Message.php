<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'recipient_id',
        'body',
        'read_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that sent the message.
     * 
     * @return BelongsTo<User, self>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user that received the message.
     * 
     * @return BelongsTo<User, self>
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}

