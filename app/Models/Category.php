<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    //
    protected $fillable =
        [
            "name",
            "slug",
            "description" ,
        ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}
