@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-4 sm:space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold">Dashboard</h1>
            <p class="text-xs sm:text-sm opacity-70">
                Browse feedback boxes.
            </p>
        </div>
        @if (auth()->user()->role == 1)
            <a href="{{ route('boxes.create') }}" class="btn btn-primary btn-sm sm:btn-md self-start sm:self-auto">
                Create Box
            </a>
        @endif

    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-3 sm:p-4 space-y-4">

            {{-- Boxes grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                @forelse($boxes as $box)
                    <x-box-card :box="$box" />
                @empty
                    <p class="col-span-full text-xs sm:text-sm opacity-60">
                        No boxes found. Create your first one!
                    </p>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($boxes instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-2 sm:mt-3 flex justify-center">
                    {{ $boxes->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
