@extends('layouts.app')

@section('title', 'Create Box')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4 sm:space-y-5">
            <div>
                <h2 class="card-title text-lg sm:text-xl">Create Box</h2>
                <p class="text-xs sm:text-sm opacity-70">
                    Define a new box where users can submit feedback.
                </p>
            </div>

            <form method="POST" action="{{ route('boxes.store') }}" enctype="multipart/form-data"
                  class="space-y-4 sm:space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Name</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="input input-bordered w-full input-sm sm:input-md"
                           value="{{ old('name') }}" required>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Image</span>
                    </label>
                    <input type="file" name="image" class="file-input file-input-bordered w-full file-input-sm sm:file-input-md">
                    <label class="label">
                        <span class="label-text-alt text-[11px] sm:text-xs opacity-70">
                            Optional thumbnail for this box.
                        </span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary px-6">
                        CREATE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
