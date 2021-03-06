<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\GamerResource;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;

class LinkedSocialAccountController extends Controller
{

    public function handleRedirect($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider)
    {
        //validate provider
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        //Create or update user
        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'username' => str_replace(' ', '', $user->getName()),
                'profile' => $user->getAvatar()

            ]
        );
        //update or create social account
        $userCreated->socialaccounts()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ]

        );
        //braodcast 
        event(new Registered($userCreated));

        //user login
        Auth::login($userCreated);

        //redirect user to home
        return redirect(RouteServiceProvider::HOME);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }
}
