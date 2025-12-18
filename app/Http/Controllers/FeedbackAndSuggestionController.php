<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackAndSuggestion;
use App\Models\Box;

class FeedbackAndSuggestionController extends Controller
{
    public function index()
    {
        $feedback = FeedbackAndSuggestion::with('user')->latest()->paginate(20);
        return view('feedback.index', compact('feedback'));
    }

    public function create(Request $request)
    {
        $box = $request->has('box') ? Box::find($request->query('box')) : null;
        return view('feedback.create', compact('box'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'box_id'  => 'required|exists:boxes,id',
            'content' => 'required',
            'type'    => 'required|in:suggestion,feedback', // matches your radios
        ]);

        // assign the created model to a variable
        $feedback = FeedbackAndSuggestion::create([
            'box_id'  => $validated['box_id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'type'    => $validated['type'],
        ]);

        return redirect()
            ->route('boxes.show', $feedback->box_id)
            ->with('success', 'Feedback submitted successfully.');
    }

    public function edit(FeedbackAndSuggestion $feedback)
    {
        $isOwner = $user->id === $feedback->user_id;
        $isAdmin = $user->role === 1;

        // only owner can edit/update
        if (! $isOwner) {
            abort(403);
        }

        return view('feedback.edit', compact('feedback'));
    }

    public function update(Request $request, FeedbackAndSuggestion $feedback)
    {
        $isOwner = $user->id === $feedback->user_id;
        $isAdmin = $user->role === 1;

        // only owner can edit/update
        if (! $isOwner) {
            abort(403);
        }

        $validated = $request->validate([
            'type'    => 'required|in:suggestion,feedback', // lowercase to match DB & form
            'content' => 'required|string',
        ]);

        $feedback->update([
            'type'    => $validated['type'],
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('boxes.show', $feedback->box_id)
            ->with('success', 'Feedback updated successfully.');
    }

    public function destroy(FeedbackAndSuggestion $feedback)
    {
        if (auth()->id() !== $feedback->user_id && auth()->user()->role !== 1) {
            abort(403);
        }
        $boxId = $feedback->box_id;

        $feedback->delete();

        return redirect()
            ->route('boxes.show', $boxId)
            ->with('success', 'Feedback deleted successfully.');
    }
}
