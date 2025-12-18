<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FeedbackAndSuggestion;
use illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Box extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'user_id',
    ];

    public function feedbacks()
    {
        return $this->hasMany(FeedbackAndSuggestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
