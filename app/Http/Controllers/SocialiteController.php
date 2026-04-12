<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class SocialiteController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (! $googleUser->getEmail()) {
                return redirect()->route('login')->withErrors([
                    'google' => 'Your Google account did not share an email address. Use email login or allow email access for Google sign-in.',
                ]);
            }

            $googleId = (string) $googleUser->getId();

            $user = User::query()
                ->where(function ($query) use ($googleId, $googleUser) {
                    $query->where('google_id', $googleId)
                        ->orWhere('email', $googleUser->getEmail());
                })
                ->first();

            if ($user) {
                if ($user->google_id !== null && (string) $user->google_id !== $googleId) {
                    return redirect()->route('login')->withErrors([
                        'google' => 'This email is already linked to a different Google account. Sign in with the account you used to register.',
                    ]);
                }

                if (! $user->google_id) {
                    $user->update(['google_id' => $googleId]);
                }

                if (! $user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                Auth::login($user);

                return redirect()->intended(route('dashboard', absolute: false));
            }

            $newUser = User::create([
                'name' => $googleUser->getName() ?: Str::before($googleUser->getEmail(), '@'),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleId,
                'password' => Str::password(32),
            ]);

            $newUser->markEmailAsVerified();

            Auth::login($newUser);

            return redirect()->intended(route('dashboard', absolute: false));

        } catch (InvalidStateException $e) {
            Log::warning('Google OAuth invalid state', ['message' => $e->getMessage()]);

            return redirect()->route('login')->withErrors([
                'google' => 'Your Google sign-in session expired. Please try again.',
            ]);
        } catch (Throwable $e) {
            Log::error('Google OAuth Error: '.$e->getMessage(), [
                'exception' => $e::class,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'google' => 'Unable to authenticate with Google. Please try again or contact support.',
            ]);
        }
    }
}
