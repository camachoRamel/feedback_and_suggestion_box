@props(['feedback'])

@php
    $type = strtolower($feedback->type ?? '');

    $typeBadgeClass = match ($type) {
        'suggestion' => 'badge-success',
        'feedback'   => 'badge-info',
    };
@endphp

<div class="card bg-base-100 shadow-md border border-base-200 hover:shadow-md transition-shadow duration-150">
    <div class="card-body py-3 px-3 sm:px-4 space-y-3">

        {{-- Header: submitter + type + timestamps + actions --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

            {{-- Left: name + type --}}
            <div class="flex items-start gap-3">
                <div class="space-y-0.5">
                    {{-- Name --}}
                    <p class="text-xs sm:text-sm font-semibold">
                        {{ $feedback->user->first_name ?? 'Unknown' }}
                        {{ $feedback->user->middle_name }}
                        {{ $feedback->user->last_name }}
                    </p>

                    {{-- Type badge (now color-coded) --}}
                    <div class="flex flex-wrap items-center gap-1.5 text-[10px] sm:text-[11px] opacity-80">
                        <span class="badge badge-xs sm:badge-sm {{ $typeBadgeClass }}">
                            {{ ucfirst($feedback->type) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Right: timestamps + actions --}}
            <div class="flex flex-col items-end gap-1 text-right">
                <span class="text-[10px] sm:text-[11px] opacity-60">
                    Submitted {{ $feedback->created_at?->diffForHumans() ?? 'recently' }}
                </span>

                @if($feedback->updated_at && $feedback->updated_at->ne($feedback->created_at))
                    <span class="text-[10px] sm:text-[11px] text-info flex items-center gap-1">
                        <span class="inline-block w-1 h-1 rounded-full bg-info"></span>
                        Edited {{ $feedback->updated_at->diffForHumans() }}
                    </span>
                @endif
                {{-- Actions: Edit + Delete --}}
                @auth
                    @php
                        $user = auth()->user();
                        $isOwner = $user->id === $feedback->user_id;
                        $isAdmin = $user->role === 1;
                    @endphp

                    <div class="flex gap-1 mt-1">
                        {{-- Only owner can see Edit --}}
                        @if($isOwner)
                            <a href="{{ route('feedback.edit', $feedback) }}"
                            class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                        @endif

                        {{-- Owner OR admin can see Delete --}}
                        @if($isOwner || $isAdmin)
                            <form action="{{ route('feedback.destroy', $feedback) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error btn-xs">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                @endauth


            </div>
        </div>

        {{-- Content --}}
        <div class="space-y-1">
            <p class="text-xs sm:text-sm mt-1 leading-snug sm:leading-relaxed">
                {{ $feedback->content }}
            </p>
        </div>

        {{-- Comments & Add comment area --}}
        <div class="mt-2 border-t border-base-200 pt-2 space-y-2">
            <details class="group">
                <summary class="flex items-center justify-between gap-2 cursor-pointer select-none">
                    <div class="flex items-center gap-2 text-[11px] sm:text-xs opacity-80">
                        <span class="btn btn-xs btn-outline">
                            Add Comment
                        </span>
                        @if($feedback->comments?->count())
                            <span>
                                • {{ $feedback->comments->count() }} comment{{ $feedback->comments->count() > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </div>
                    <span class="text-[10px] sm:text-[11px] opacity-50 group-open:rotate-180 transition-transform">
                        ▼
                    </span>
                </summary>

                <form method="POST"
                      action="{{ route('feedbacks.comments.store', $feedback) }}"
                      class="mt-3 space-y-2">
                    @csrf

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-[11px] sm:text-xs">Comment</span>
                        </label>
                        <textarea
                            name="content"
                            rows="2"
                            class="textarea textarea-bordered textarea-xs sm:textarea-sm w-full"
                            placeholder="Share your thoughts about this feedback…"
                            required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-xs sm:btn-sm btn-primary">
                            Post Comment
                        </button>
                    </div>
                </form>
            </details>

            @if($feedback->comments?->count())
                <div class="mt-2 space-y-2 rounded-lg bg-base-200/60 px-2 sm:px-3 py-2 max-h-56 overflow-y-auto">
                    @foreach($feedback->comments as $comment)
                        <x-comment :comment="$comment" :feedback="$feedback" />
                        @if(!$loop->last)
                            <div class="border-t border-base-300/60 my-1"></div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
