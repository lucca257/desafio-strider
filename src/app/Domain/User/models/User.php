<?php

namespace App\Domain\User\models;

use App\Domain\Post\model\Post;
use App\Domain\Post\model\QuotePost;
use App\Domain\Post\model\ReplyPost;
use App\Domain\Post\model\Repost;
use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait;

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function reposts(): HasMany
    {
        return $this->hasMany(Repost::class);
    }

    /**
     * @return HasMany
     */
    public function quotePosts(): HasMany
    {
        return $this->hasMany(QuotePost::class);
    }

    public function replyPosts(): HasMany
    {
        return $this->hasMany(ReplyPost::class);
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follows::class, 'follower_id','id');
    }

    public function followereds(): HasMany
    {
        return $this->hasMany(Follows::class, 'followered_id','id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
