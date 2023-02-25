<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

// actions
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

class UpdateUser
{

    use AsAction;

    public function handle(ActionRequest $request, array $data)
    {
        $request->user()->update($data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id]
        ];
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $this->handle($request, $request->user()->only('name', 'email'));

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
