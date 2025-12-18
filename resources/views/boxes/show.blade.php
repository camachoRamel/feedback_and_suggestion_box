@extends('layouts.app')

@section('title', $box->name . ' – Box')

@section('content')
<div class="space-y-4 sm:space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">

            {{-- IMAGE AVATAR OR INITIALS --}}
            @if($box->image)
                <div class="avatar">
                    <div class="w-10 sm:w-12 rounded-full overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $box->image) }}"
                            alt="{{ $box->name }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="w-10 sm:w-12 rounded-full bg-neutral-focus text-neutral-content">
                        <span class="text-xs sm:text-sm">
                            {{ strtoupper(substr($box->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="space-y-1">
                <h1 class="text-xl sm:text-2xl font-bold break-words">
                    {{ $box->name }}
                </h1>
                <p class="text-[11px] sm:text-xs opacity-70">
                    Created {{ $box->created_at?->diffForHumans() ?? 'recently' }}
                </p>
            </div>
        </div>

        <a href="{{ route('feedback.create', ['box' => $box]) }}"
           class="btn btn-primary btn-sm sm:btn-md self-start sm:self-auto">
            ADD
        </a>
    </div>

    {{-- Optional: bigger banner image under header --}}
    @if($box->image)
        <div class="w-full h-40 sm:h-56 rounded-xl overflow-hidden bg-base-200">
            <img
                src="{{ asset('storage/' . $box->image) }}"
                alt="{{ $box->name }}"
                class="w-full h-full object-cover"
            >
        </div>
    @endif

    <div class="card bg-base-100 shadow">
        <div class="card-body p-3 sm:p-4">
            <div class="max-h-[28rem] sm:max-h-[32rem] overflow-y-auto space-y-3">
                @forelse($box->feedbacks ?: [] as $item)
                    <x-feedback-card :feedback="$item" />
                @empty
                    <p class="text-xs sm:text-sm opacity-60">
                        No feedback in this box yet.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
