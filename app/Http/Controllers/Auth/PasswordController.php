<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
   public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($request) {
                $pepper = env('APP_PEPPER');
                $pepperedPassword = hash_hmac('sha256', $value, $pepper);
                if (!\Illuminate\Support\Facades\Hash::check($pepperedPassword, $request->user()->password)) {
                    $fail(__('The provided password does not match your current password.'));
                }
            }],
            'password' => ['required', \Illuminate\Validation\Rules\Password::defaults(), 'confirmed'],
        ]);

        $pepper = env('APP_PEPPER');
        $pepperedNewPassword = hash_hmac('sha256', $validated['password'], $pepper);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($pepperedNewPassword),
        ]);

        return back()->with('status', 'password-updated');
    }
}
