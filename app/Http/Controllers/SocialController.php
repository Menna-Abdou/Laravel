<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
class SocialController extends Controller
{
    public function redirect($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect('/login');
        };
    }

    public function callback($provider)
    {
        $userProviderInfo = Socialite::driver($provider)->user();
        $user = $this->getUser($userProviderInfo, $provider);
        auth()->login($user);
        return redirect()->to('/posts');
    }

    public function getUser($userProviderInfo, $provider)
    {
        $user = User::where('social_id', $userProviderInfo->id)->first() ? User::where('social_id', $userProviderInfo->id)->first() : User::where('email', $userProviderInfo->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $userProviderInfo->name,
                'email' => $userProviderInfo->email,
                'password' => encrypt('12345678'),
                'social_id' => $userProviderInfo->id,
                'social_type' => $provider,
                'social_token' => $userProviderInfo->token,
            ]);
        }
        return $user;
    }
}
