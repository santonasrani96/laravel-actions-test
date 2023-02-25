<?php

namespace App\Http\Controllers\Actions;

use Illuminate\View\View;
use Illuminate\Http\Request;

// actions
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserProfile
{

    use AsAction;

    public function handle(Request $request): Request
    {
        return $request;
    }

    public function htmlResponse(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }
}
