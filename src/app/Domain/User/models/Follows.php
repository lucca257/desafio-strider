<?php

namespace App\Domain\User\models;

use App\Domain\Post\model\Post;
use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id','follower_id' );
    }

    public function followered()
    {
        return $this->hasOne(User::class, 'id','follower_id' );
    }
}
