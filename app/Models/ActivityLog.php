<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    //
    protected $fillable = [
        "performer_id",
        "performer",
        "type_of_action",
        "entity_type",
        "entity_id",
        "changed_fields",
        "timestamp",
    ];
    public $timestamps = false;

    protected $casts=[
        "changed_fields"=>'array',
    ];
    protected static function booted(): void
    {
        static::creating(function ($task) {
            $task->timestamp = now();
        });
    }

    public function performerUser(): BelongsTo
    {
        return $this->belongsTo(User::class,'performer_id');
    }

}
