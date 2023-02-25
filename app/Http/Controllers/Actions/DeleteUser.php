<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

// actions
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class DeleteUser
{
    use AsAction;

    public function handle(ActionRequest $request, object $user): void
    {
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'current-password']
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'userDeletion';
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        $request->validated();

        $this->handle($request, $request->user());

        return Redirect::to('/');
    }
}
