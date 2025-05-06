<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
#[ObservedBy([CategoryObserver::class])]

class Category extends Model
{
    use HasFactory;
    //
    protected $fillable =
        [
            "name",
            "slug",
            "description",
        ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}


