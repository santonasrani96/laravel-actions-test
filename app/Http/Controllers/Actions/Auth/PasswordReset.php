<?php

namespace App\Http\Controllers\Actions\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

// actions
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class PasswordReset
{
    use AsAction;

    public function handle(Password $password, array $data)
    {
        return $password::sendResetLink($data);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
        ];
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        $request->validated();

        $status = $this->handle(new Password, $request->only('email'));

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
