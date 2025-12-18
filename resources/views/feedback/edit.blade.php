@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
@php
    $type = strtolower($feedback->type ?? '');

    $typeBadgeClass = match ($type) {
        'suggestion' => 'badge-success',
        'feedback'   => 'badge-info',
        default      => 'badge-ghost',
    };
@endphp

<div class="max-w-2xl mx-auto space-y-4 sm:space-y-5">

    {{-- Page header --}}
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold">Edit Feedback</h1>
            <p class="text-[11px] sm:text-xs opacity-70 mt-1">
                You can change the feedback type and content. The box and owner stay the same.
            </p>
        </div>
    </div>

    {{-- Context card (who, type, timestamps) --}}
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body py-3 px-3 sm:px-4 space-y-2">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                <div class="space-y-0.5">
                    <p class="text-xs sm:text-sm font-semibold">
                        {{ $feedback->user->first_name ?? 'Unknown' }}
                        {{ $feedback->user->middle_name }}
                        {{ $feedback->user->last_name }}
                    </p>

                    <div class="flex flex-wrap items-center gap-1.5 text-[10px] sm:text-[11px] opacity-80">
                        <span class="badge badge-xs sm:badge-sm {{ $typeBadgeClass }}">
                            {{ ucfirst($feedback->type) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1 text-right">
                    <span class="text-[10px] sm:text-[11px] opacity-60">
                        Submitted {{ $feedback->created_at?->diffForHumans() ?? 'recently' }}
                    </span>

                    @if($feedback->updated_at && $feedback->updated_at->ne($feedback->created_at))
                        <span class="text-[10px] sm:text-[11px] text-info flex items-center gap-1">
                            <span class="inline-block w-1 h-1 rounded-full bg-info"></span>
                            Last edited {{ $feedback->updated_at->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>

            <p class="text-[11px] sm:text-sm mt-1 leading-snug sm:leading-relaxed opacity-80">
                {{ $feedback->content }}
            </p>
        </div>
    </div>

    {{-- Edit form: TYPE + CONTENT --}}
    <div class="card bg-base-100 shadow-md border border-base-200">
        <div class="card-body py-4 px-3 sm:px-5 space-y-4">
            <h2 class="text-sm sm:text-base font-semibold">
                Update feedback
            </h2>

            <form method="POST" action="{{ route('feedback.update', $feedback) }}" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Type --}}
                <div>
                    <label class="block text-xs sm:text-sm font-semibold mb-1">
                        Type
                    </label>
                    <div class="flex flex-wrap gap-4 text-[11px] sm:text-xs">
                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio"
                                   name="type"
                                   value="suggestion"
                                   class="radio radio-xs sm:radio-sm"
                                   {{ old('type', $feedback->type) === 'suggestion' ? 'checked' : '' }}>
                            <span class="label-text">Suggestion</span>
                        </label>

                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio"
                                   name="type"
                                   value="feedback"
                                   class="radio radio-xs sm:radio-sm"
                                   {{ old('type', $feedback->type) === 'feedback' ? 'checked' : '' }}>
                            <span class="label-text">Feedback</span>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-error text-[10px] sm:text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label class="block text-xs sm:text-sm font-semibold mb-1">
                        Content
                    </label>
                    <textarea
                        name="content"
                        rows="4"
                        class="textarea textarea-bordered w-full text-xs sm:text-sm leading-snug sm:leading-relaxed"
                        placeholder="Update the feedback content here…"
                        required>{{ old('content', $feedback->content) }}</textarea>
                    @error('content')
                        <p class="text-error text-[10px] sm:text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-[10px] sm:text-[11px] opacity-60">
                        Saving will update the “Edited” timestamp.
                    </span>

                    <div class="flex gap-2">
                        <a href="{{ url()->previous() }}"
                           class="btn btn-ghost btn-xs sm:btn-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-xs sm:btn-sm">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
