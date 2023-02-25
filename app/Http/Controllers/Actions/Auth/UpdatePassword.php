<?php

namespace App\Http\Controllers\Actions\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

// actions
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class UpdatePassword
{
    use AsAction;

    public function handle(User $user, array $data)
    {
        return $user->update($data);
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed']
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updatePassword';
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        $request->validated();

        $this->handle($request->user(), [
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
