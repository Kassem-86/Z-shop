<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return FacadesSocialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Check if the user already exists in the database
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // Log in the existing user
                Auth::login($existingUser);
            } else {
                // Create a new user if not found
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('random_password'), // Can be left empty or random
                ]);
                Auth::login($newUser);
            }

            // Redirect to the home page or wherever you want
            return redirect()->intended('/');
        } catch (Exception $e) {
            // Handle the exception and redirect back with an error message
            return redirect()->route('login')->withErrors(['msg' => 'Login failed.']);
        }
    }
}
