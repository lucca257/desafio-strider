<?php

namespace App\Domain\Post\model;

use App\Domain\User\models\User;
use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repost extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
