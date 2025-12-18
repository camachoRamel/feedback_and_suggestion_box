<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\FeedbackAndSuggestion; // model for feedbacks_and_suggestions table
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * List comments (optionally all, usually per feedback).
     */
    public function index(FeedbackAndSuggestion $feedback)
    {
        $comments = Comment::with(['user', 'children'])
            ->where('feedbacks_and_suggestions_id', $feedback->id)
            ->latest()
            ->paginate(10);

        return view('comments.index', compact('feedback', 'comments'));
    }

    /**
     * Show create form.
     */
    public function create(FeedbackAndSuggestion $feedback)
    {
        // if you want to reply to a comment, pass ?parent_id=ID in the URL
        $parentId = request('parent_id');

        return view('comments.create', [
            'feedback'  => $feedback,
            'parentId'  => $parentId,
        ]);
    }

    /**
     * Store new comment.
     */
    public function store(Request $request, FeedbackAndSuggestion $feedback)
    {
        $data = $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'feedback_and_suggestion_id' => $feedback->id,
            'comment_id'                 => $data['parent_id'] ?? null, // <-- parent comment id
            'user_id'                    => Auth::id(),
            'likes'                      => 0,
            'content'                    => $data['content'],
        ]);

        return back()->with('success', 'Comment added.');
    }

    /**
     * Show a single comment (with replies).
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'feedback', 'children.user']);

        return view('comments.show', compact('comment'));
    }

    /**
     * Show edit form.
     */
    public function edit(Comment $comment)
    {
        // optional: add policy
        // $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // optional: add policy
        // $this->authorize('update', $comment);

        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $data['content'],
        ]);

        return redirect()
            ->route('comments.show', $comment)
            ->with('success', 'Comment updated.');
    }

    /**
     * Soft-delete comment.
     */
    public function destroy(Comment $comment)
    {
        // optional: add policy
        // $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
