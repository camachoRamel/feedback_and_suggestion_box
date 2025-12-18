<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Box;
use App\Models\User;
use App\Models\Comment;

class FeedbackAndSuggestion extends Model
{
    protected $table = 'feedbacks_and_suggestions';

    use SoftDeletes;

    protected $fillable = [
        'box_id',
        'user_id',
        'content',
        'type',
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // To get top-level comments only
    public function comments()
    {
        return $this->hasMany(Comment::class, 'feedback_and_suggestion_id')
                    ->whereNull('comment_id')
                    ->with(['children.user', 'user']);
    }


}
