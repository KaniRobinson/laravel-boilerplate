<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $canRegister = Features::enabled(
            Features::registration(),
        );

        return Inertia::render('Welcome', compact('canRegister'));
    }
}
