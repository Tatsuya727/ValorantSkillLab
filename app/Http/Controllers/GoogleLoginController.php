<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')->user();
            $email = $socialiteUser->email;

            $user = User::firstorCreate(
                ['email' => $email],
                ['name' => $socialiteUser->name,]
            );

            // providerにgoogleをセット
            if ($user->provider !== 'google') {
                $user->provider = 'google';
                $user->save();
            }

            Auth::login($user, true);

            // ルートページにリダイレクト
            return redirect()->route('spots.index');
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
