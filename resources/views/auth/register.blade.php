@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="space-y-5 sm:space-y-6">
    <div class="text-center space-y-1">
        <h1 class="text-2xl sm:text-3xl font-bold">Create an account</h1>
        <p class="text-xs sm:text-sm opacity-70">
            Register as a customer or admin.
        </p>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4 sm:space-y-5">
            <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5">
                @csrf

                {{-- Type --}}
                <div class="form-control">
                    <span class="label-text mb-2 font-medium text-sm">Type</span>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio" name="type" value="0" class="radio radio-sm" checked>
                            <span class="label-text">Customer</span>
                        </label>
                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio" name="type" value="1" class="radio radio-sm">
                            <span class="label-text">Admin</span>
                        </label>
                    </div>
                </div>

                {{-- Names --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">First name</span>
                        </label>
                        <input type="text" name="first_name"
                               class="input input-bordered input-sm sm:input-md"
                               value="{{ old('first_name') }}" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Middle name</span>
                        </label>
                        <input type="text" name="middle_name"
                               class="input input-bordered input-sm sm:input-md"
                               value="{{ old('middle_name') }}">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Last name</span>
                        </label>
                        <input type="text" name="last_name"
                               class="input input-bordered input-sm sm:input-md"
                               value="{{ old('last_name') }}" required>
                    </div>
                </div>

                {{-- Username / password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Username</span>
                        </label>
                        <input type="text" name="username"
                               class="input input-bordered input-sm sm:input-md"
                               value="{{ old('username') }}" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Password</span>
                        </label>
                        <input type="password" name="password"
                               class="input input-bordered input-sm sm:input-md" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full mt-2">
                    REGISTER
                </button>
            </form>

            <div class="text-center text-xs sm:text-sm">
                <span>Already have an account?</span>
                <a href="{{ route('showLoginForm') }}" class="link link-primary ml-1">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
