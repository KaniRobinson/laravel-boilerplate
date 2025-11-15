<?php

namespace App\Http\Controllers\Chats;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Ramsey\Uuid\Uuid;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return Response
     */
    public function __invoke(Request $request, User $user): Response
    {
        abort_if($request->user()->is($user), 404);

        $conversationId = Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            sprintf('%s-%s', min($request->user()->id, $user->id), max($request->user()->id, $user->id)),
        );

        $messages = Message::query()
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'ASC')
            ->get();

        return Inertia::render('chats/Show', [
            'user' => $user,
            'messages' => $messages,
            'presence_channel' => sprintf('chats.conversation.%s', $conversationId),
        ]);
    }
}

