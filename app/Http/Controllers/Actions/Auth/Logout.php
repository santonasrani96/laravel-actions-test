<?php

namespace App\Http\Controllers\Actions\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

// actions
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class Logout
{
    use AsAction;

    public function handle(ActionRequest $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        $this->handle($request);
        return redirect('/');
    }
}
