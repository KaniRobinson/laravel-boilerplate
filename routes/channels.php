<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn(User $user, int $id) => (int) $user->id === (int) $id);

Broadcast::channel('chats.conversation.{conversationId}', fn (User $user, string $conversationId) => $user);
