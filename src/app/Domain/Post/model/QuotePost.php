<?php

namespace App\Domain\Post\model;

use App\Domain\User\models\User;
use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuotePost extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
