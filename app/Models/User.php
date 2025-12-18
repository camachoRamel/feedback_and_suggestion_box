<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Comment;
use App\Models\Box;
use App\Models\FeedbackAndSuggestion;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'password',
        'role',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    public function feedbacksAndSuggestions(): HasMany
    {
        return $this->hasMany(FeedbackAndSuggestion::class);
    }

}
