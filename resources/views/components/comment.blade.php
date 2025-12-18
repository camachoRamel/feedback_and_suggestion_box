@props([
    'comment',
    'feedback',
    'level' => 0, // nesting level
])

<div class="mb-2 @if($level > 0) ml-3 sm:ml-4 border-l border-base-300/60 pl-2 sm:pl-3 @endif">
    <div class="rounded-lg bg-base-100 border border-base-200/70 px-2.5 sm:px-3 py-2.5 sm:py-3 text-[11px] sm:text-xs">
        <div class="flex gap-2 sm:gap-3">
            <div class="flex-1 space-y-1">
                {{-- Header: name + time --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                    <div>
                        <p class="font-semibold leading-none">
                            {{ $comment->user->first_name }}
                            {{ $comment->user->middle_name }}
                            {{ $comment->user->last_name }}
                        </p>
                        <p class="opacity-70 leading-none mt-0.5">
                            {{ $comment->created_at?->diffForHumans() ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Comment text --}}
                <p class="mt-1 leading-snug sm:leading-relaxed">
                    {{ $comment->content }}
                </p>

                {{-- Reply section --}}
                <details class="mt-1.5 group">
                    <summary class="flex items-center justify-between gap-2 cursor-pointer select-none">
                        <span class="btn btn-ghost btn-xs px-2 sm:px-3 h-6 sm:h-7 min-h-0 text-[10px] sm:text-[11px]">
                            Reply
                        </span>
                        <span class="text-[9px] sm:text-[10px] opacity-50 group-open:rotate-180 transition-transform">
                            ▼
                        </span>
                    </summary>

                    <form method="POST"
                          action="{{ route('feedbacks.comments.store', $feedback) }}"
                          class="mt-2 space-y-2">
                        @csrf

                        {{-- THIS links the reply to its parent comment --}}
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                        <div class="form-control">
                            <textarea
                                name="content"
                                rows="2"
                                class="textarea textarea-bordered textarea-xs sm:textarea-sm w-full"
                                placeholder="Write your reply…"
                                required></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button"
                                    class="btn btn-ghost btn-xs sm:btn-sm"
                                    onclick="this.closest('details').removeAttribute('open')">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-primary btn-xs sm:btn-sm">
                                Post Reply
                            </button>
                        </div>
                    </form>
                </details>
            </div>
        </div>
    </div>

    {{-- Child replies --}}
    @if($comment->children?->count())
        <div class="mt-2 space-y-2">
            @foreach($comment->children as $child)
                <x-comment :comment="$child" :feedback="$feedback" :level="$level + 1" />
            @endforeach
        </div>
    @endif
</div>
