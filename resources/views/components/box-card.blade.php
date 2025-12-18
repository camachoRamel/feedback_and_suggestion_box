@props(['box'])

<div class="relative">
    <a href="{{ route('boxes.show', $box) }}"
       class="card bg-base-100 shadow hover:shadow-lg transition-shadow duration-150">
        <figure class="h-28 sm:h-32 bg-base-200 flex items-center justify-center overflow-hidden">
            @if($box->image)
                <img
                    src="{{ asset('storage/' . $box->image) }}"
                    alt="{{ $box->name }}"
                    class="h-full w-full object-cover"
                >
            @else
                <span class="text-[10px] sm:text-xs opacity-60">No image</span>
            @endif
        </figure>

        <div class="card-body py-3 px-3 sm:px-4">
            <h2 class="card-title text-sm sm:text-base truncate">{{ $box->name }}</h2>
            <p class="text-[11px] sm:text-xs opacity-70">
                Created {{ $box->created_at?->diffForHumans() ?? 'recently' }}
            </p>
        </div>
    </a>

    @auth
        @if(auth()->user()->role === 1)
            <div class="absolute top-2 right-2 flex gap-1 z-10">
                <a href="{{ route('boxes.edit', $box) }}"
                   class="btn btn-ghost btn-xs bg-base-100/80">
                    Edit
                </a>

                <form action="{{ route('boxes.destroy', $box) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this box?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-xs bg-base-100/80">
                        Delete
                    </button>
                </form>
            </div>
        @endif
    @endauth
</div>
