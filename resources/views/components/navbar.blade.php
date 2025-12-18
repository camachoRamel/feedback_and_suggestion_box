<nav class="navbar bg-base-100 shadow sticky top-0 z-40 px-4 sm:px-6">
    <div class="flex-1">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-lg sm:text-xl font-bold">
            FeedbackBox
        </a>
    </div>

    {{-- Desktop menu --}}
    <div class="hidden md:flex items-center gap-4">
        <ul class="menu menu-horizontal px-1 text-sm">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (auth()->user()->role == 1)
                    <li><a href="{{ route('boxes.create') }}">Create Box</a></li>
                @endif
        </ul>

        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                <div class="bg-neutral-focus text-neutral-content rounded-full w-9 sm:w-10">
                    <span class="text-xs sm:text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </span>
                </div>
            </label>
            <ul tabindex="0"
                class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52 text-sm">
                <li class="px-2 py-1 opacity-80">
                    {{ auth()->user()->name ?? 'User' }}
                </li>
                <div class="divider my-1"></div>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="md:hidden">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-square">
                <span class="text-xl">☰</span>
            </label>
            <ul tabindex="0"
                class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52 text-sm">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (auth()->user()->role == 1)
                    <li><a href="{{ route('boxes.create') }}">Create Box</a></li>
                @endif
                <div class="divider my-1"></div>
                <li class="px-2 py-1 opacity-80">
                    {{ auth()->user()->first_name . auth()->user()->middle_name . auth()->user()->last_name ?? 'User' }}
                </li>
                <li>
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
