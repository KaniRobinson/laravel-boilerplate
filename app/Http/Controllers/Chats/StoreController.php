<?php

namespace App\Http\Controllers\Chats;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return RedirectResponse
     */
    public function __invoke(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 404);

        $conversationId = Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            sprintf('%s-%s', min($request->user()->id, $user->id), max($request->user()->id, $user->id)),
        );

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $request->user()->id,
            'recipient_id' => $user->id,
            'body' => $request->input('body'),
        ]);

        broadcast(new MessageSent($message));

        return redirect()
            ->back();
    }
}

