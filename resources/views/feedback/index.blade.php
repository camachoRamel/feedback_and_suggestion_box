@extends('layouts.app')

@section('title', 'Feedback List')

@section('content')
<div class="space-y-4 sm:space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold">Feedback Dashboard</h1>
            <p class="text-xs sm:text-sm opacity-70">
                View all submitted feedback and suggestions.
            </p>
        </div>

        <a href="{{ route('feedback.create') }}" class="btn btn-primary btn-sm sm:btn-md self-start sm:self-auto">
            Add Feedback
        </a>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-3 sm:p-4">
            <div class="max-h-[28rem] sm:max-h-[32rem] overflow-y-auto space-y-3">
                @forelse($feedback as $item)
                    <x-feedback-card :feedback="$item" />
                @empty
                    <p class="text-xs sm:text-sm opacity-60">
                        No feedback yet.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
