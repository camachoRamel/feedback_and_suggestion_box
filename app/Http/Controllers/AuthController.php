<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Log::info('User logged in', [
                'user_id'  => Auth::id(),
                'username' => Auth::user()->username,
                'role'     => Auth::user()->role,
                'ip'       => $request->ip(),
            ]);

            return redirect()->route('dashboard');
        }

        Log::warning('Failed login attempt', [
            'username' => $request->input('username'),
            'ip'       => $request->ip(),
        ]);

        return redirect('/')
            ->with('incorrect', 'Incorrect password or username');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required',
            'first_name'  => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'username'    => ['required', 'string', 'max:100', 'unique:users,username'],
            'password'    => ['required', 'string', 'min:6'],
        ]);

        // Map type -> numeric role (0=user, 1=admin)
        $role = $validated['type'] === 'admin' ? 1 : 0;

        $user = User::create([
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name'   => $validated['last_name'],
            'username'    => $validated['username'],
            'password'    => Hash::make($validated['password']),
            'role'        => $role,
        ]);

        Log::info('New user registered', [
            'user_id'  => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
            'ip'       => $request->ip(),
        ]);

        return redirect()->route('showLoginForm');
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            Log::info('User logged out', [
                'user_id'  => auth()->id(),
                'username' => auth()->user()->username,
                'ip'       => $request->ip(),
            ]);
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
