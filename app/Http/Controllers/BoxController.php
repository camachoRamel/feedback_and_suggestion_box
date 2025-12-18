<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use Illuminate\Support\Facades\Storage;

class BoxController extends Controller
{
    public function index()
    {
        $boxes = Box::orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard', compact('boxes'));
    }

    public function create()
    {
        return view('boxes.create');
    }

    public function store(Request $request)
    {
        // 1. Validate incoming data
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        // 2. Create a new Box instance
        $box = new Box();
        $box->name    = $validated['name'];
        $box->user_id = auth()->id();

        // 3. Handle image upload (optional)
        if ($request->hasFile('image')) {
            $path      = $request->file('image')->store('boxes', 'public');
            $box->image = $path;
        }

        // 4. Save to database
        $box->save();

        \Log::info('Box created', [
            'box_id'  => $box->id,
            'user_id' => $box->user_id,
            'name'    => $box->name,
        ]);

        // 5. Redirect to the show page (or dashboard) with a success message
        return redirect()
            ->route('boxes.show', $box)
            ->with('success', 'Box created successfully.');
    }

    public function show(Box $box)
    {
        // Eager-load relationships to avoid N+1 queries
        $box->load([
            'feedbacks' => function ($query) {
                $query->latest();
            },
            'feedbacks.user',
            'feedbacks.comments.user',
        ]);

        return view('boxes.show', compact('box'));
    }

    public function edit(Box $box)
    {
        // Show edit form for this box
        return view('boxes.edit', compact('box'));
    }

    public function update(Request $request, Box $box)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        // If a new image is uploaded, delete old one and save the new path
        if ($request->hasFile('image')) {
            if ($box->image) {
                Storage::disk('public')->delete($box->image);
            }

            $data['image'] = $request->file('image')->store('boxes', 'public');
        }

        $box->update($data);

        return redirect()
            ->route('dashboard', $box)
            ->with('success', 'Box updated successfully.');
    }

    public function destroy(Box $box)
    {
        // Delete image file if it exists
        if ($box->image) {
            Storage::disk('public')->delete($box->image);
        }

        $box->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Box deleted successfully.');
    }
}
