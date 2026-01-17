<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    // Proses login (UPDATED)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Redirect ke halaman sebelumnya jika ada
            $redirectTo = $request->input('redirect', route('home'));

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome back, Admin!');
            }

            return redirect($redirectTo)
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Tampilkan halaman register
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Account created successfully! Welcome to Pearlbeads.co');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
