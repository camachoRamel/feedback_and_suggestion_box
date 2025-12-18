@extends('layouts.app')

@section('title', 'Edit Box')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4 sm:space-y-5">
            <div>
                <h2 class="card-title text-lg sm:text-xl">Edit Box</h2>
                <p class="text-xs sm:text-sm opacity-70">
                    Update this box’s details. Feedback and comments inside it will stay.
                </p>
            </div>

            <form method="POST"
                  action="{{ route('boxes.update', $box) }}"
                  enctype="multipart/form-data"
                  class="space-y-4 sm:space-y-5">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">Name</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="input input-bordered w-full input-sm sm:input-md"
                           value="{{ old('name', $box->name) }}"
                           required>
                    @error('name')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Current image preview (if any) --}}
                @if($box->image)
                    <div class="form-control">
                        <span class="label-text text-sm mb-2">Current Image</span>
                        <div class="w-full h-32 rounded-lg overflow-hidden bg-base-200">
                            <img src="{{ asset('storage/' . $box->image) }}"
                                 alt="{{ $box->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <span class="label-text-alt text-[11px] sm:text-xs opacity-70 mt-1">
                            You can upload a new image below to replace this one.
                        </span>
                    </div>
                @endif

                {{-- New image --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-sm">New Image (optional)</span>
                    </label>
                    <input type="file"
                           name="image"
                           class="file-input file-input-bordered w-full file-input-sm sm:file-input-md">
                    <label class="label">
                        <span class="label-text-alt text-[11px] sm:text-xs opacity-70">
                            Leave this empty to keep the current image.
                        </span>
                    </label>
                    @error('image')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('boxes.show', $box) }}"
                       class="btn btn-ghost btn-xs sm:btn-sm">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-6">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
