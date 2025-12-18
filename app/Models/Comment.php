<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\FeedbackAndSuggestion;
use App\Models\User;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'box_id',
        'feedback_and_suggestion_id',   // <-- add this
        'comment_id',
        'user_id',
        'likes',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedbackAndSuggestion()
    {
        return $this->belongsTo(FeedbackAndSuggestion::class, 'feedbacks_and_suggestions_id');
    }

    // Parent comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    // Child comments (replies)
    public function children()
    {
        return $this->hasMany(Comment::class, 'comment_id')
                    ->with(['children.user']); // recursive
    }

}
