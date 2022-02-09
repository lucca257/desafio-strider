<?php

namespace App\Domain\Post\model;

use App\Domain\User\models\User;
use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function repost()
    {
        return $this->hasMany(Repost::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function quotePosts()
    {
        return $this->hasMany(QuotePost::class);
    }
}
