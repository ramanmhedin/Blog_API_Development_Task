<?php

namespace App\Observers;

use App\Models\Post;
use App\Traits\HandelActivityLog;

class PostObserver
{
    use HandelActivityLog;

    public function created(Post $post): void
    {
        $activityLogData=[
            "type_of_action" => 'CREATE',
            "entity_type" => 'Post',
            "entity_id" =>$post->id,
        ];
        $this->createActivityLog($activityLogData);
    }
    public function updated(Post $post): void
    {
        $activityLogData=[
            "type_of_action" => 'UPDATE',
            "entity_type" => 'Post',
            "entity_id" =>$post->id,
            "changed_fields" => $post->getChanges()
        ];
        $this->createActivityLog($activityLogData);
    }


    public function deleted(Post $post): void
    {
        $activityLogData=[
            "type_of_action" => 'DELETE',
            "entity_type" => 'Post',
            "entity_id" =>$post->id,
        ];
        $this->createActivityLog($activityLogData);
    }


    public function retrieved(Post $post): void
    {
        $activityLogData=[
            "type_of_action" => 'READ',
            "entity_type" => 'Post',
            "entity_id" =>$post->id,
        ];
        $this->createActivityLog($activityLogData);
    }


}
