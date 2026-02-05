<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function GoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function GoogleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find user by google_id or email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update google_id if user exists but registered normally
                if (! $user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'email_verified_at' => $user->email_verified_at ?? now(),
                    ]);
                }

                Auth::login($user);

                return redirect()->intended('dashboard');
            }

            // Create new user
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]);

            Auth::login($newUser);

            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            Log::error('Google OAuth Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->with('error',
                'Unable to authenticate with Google. Please try again or contact support.'
            );
        }
    }
}
