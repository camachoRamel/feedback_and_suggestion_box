@extends('layouts.app')

@section('title', 'Submit Feedback')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4 sm:space-y-5">
            <div>
                <h2 class="card-title text-lg sm:text-xl">User Feedback Form</h2>
                <p class="text-xs sm:text-sm opacity-70">
                    Share your suggestions or feedback.
                </p>
            </div>

            <form method="POST" action="{{ route('feedback.store') }}" class="space-y-4 sm:space-y-5">
                @csrf

                {{-- Type --}}
                <input type="text" class="hidden" name="box_id" value="{{ $box->id }}">
                <div class="form-control">
                    <span class="label-text mb-2 font-medium text-sm">Type</span>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio" name="type" value="suggestion" class="radio radio-sm" checked>
                            <span class="label-text">Suggestion</span>
                        </label>
                        <label class="label cursor-pointer gap-2 p-0">
                            <input type="radio" name="type" value="feedback" class="radio radio-sm">
                            <span class="label-text">Feedback</span>
                        </label>
                    </div>
                </div>

                {{-- Content --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Description</span>
                    </label>
                    <textarea name="content"
                              rows="5"
                              class="textarea textarea-bordered w-full text-sm"
                              required>{{ old('description') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary px-6">
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
