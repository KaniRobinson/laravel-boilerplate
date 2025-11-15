<?php

namespace App\Http\Controllers\Chats;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $users = User::query()
            ->whereKeyNot($request->user()->id)
            ->select(['id', 'name', 'email', 'last_seen_at'])
            ->orderByDesc('last_seen_at')
            ->get();

        return Inertia::render('chats/Index', [
            'users' => $users,
            'presence_channel' => 'chats.users',
        ]);
    }
}

