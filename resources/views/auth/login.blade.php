@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="space-y-5 sm:space-y-6">
    <div class="text-center space-y-1">
        <h1 class="text-2xl sm:text-3xl font-bold">Welcome back</h1>
        <p class="text-xs sm:text-sm opacity-70">
            Login to access your feedback boxes.
        </p>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4 sm:space-y-5">
            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Username</span>
                    </label>
                    <input type="text"
                           name="username"
                           value="{{ old('username') }}"
                           class="input input-bordered w-full text-sm"
                           required autofocus>
                    @error('username')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Password</span>
                    </label>
                    <input type="password"
                           name="password"
                           class="input input-bordered w-full text-sm"
                           required>
                    @error('password')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full mt-2">
                    LOGIN
                </button>
            </form>

            <div class="text-center text-xs sm:text-sm">
                <span>Don’t have an account?</span>
                <a href="{{ route('showRegisterForm') }}" class="link link-primary ml-1">Register</a>
            </div>
        </div>
    </div>
</div>
@endsection
