<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function checkUserExistence(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);
        $isEmailExisted = User::where('email', $request->input('email'))->exists();
        return Response::make([
            'email' => $request->input('email'),
            'existed' => $isEmailExisted
        ]);
    }

    public function register(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'password' => ['required', 'confirmed']
        ]);

        $user = User::create($request->only(['email', 'name', 'password']));
        Auth::login($user);
        $request->session()->regenerate();
        return Response::make($user);
    }

    public function login(Request $request): \Illuminate\Http\Response
    {
        $creds = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $attempt = Auth::attempt($creds);
        if (!$attempt)
            return Response::make([
                'errors' => [
                    'password' => 'Password is incorrect'
                ]
            ], 422);

        $request->session()->regenerate();
        return Response::make(Auth::user());
    }

    public function getCurrentUser(Request $request): \Illuminate\Http\Response
    {
        return Response::make(Auth::user());
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->regenerate();
        return null;
    }
}
