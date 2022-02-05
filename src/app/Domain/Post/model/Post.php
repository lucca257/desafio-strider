<?php

namespace App\Domain\Post\model;

use App\Support\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];
}
