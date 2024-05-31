<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function handleCallback(
    ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        logger()->info('user', [
            $githubUser->getId(), $githubUser->id, $githubUser->token
        ]);
        $user = User::query()->updateOrCreate(
            [
                'github_id' => $githubUser->id,
            ], [
            'name'                 => $githubUser->name ?? $githubUser->getNickname(),
            'email'                => $githubUser->email,
            'password'             => Str::password(),
            'github_id'            => $githubUser->getId(),
            'github_token'         => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
