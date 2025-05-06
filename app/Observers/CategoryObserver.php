<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\HandelActivityLog;

use Illuminate\Support\Str;

class CategoryObserver
{
    use HandelActivityLog;

    public function created(Category $category): void
    {
        $activityLogData=[
            "type_of_action" => 'CREATE',
            "entity_type" => 'Category',
            "entity_id" =>$category->id,
        ];
        $this->createActivityLog($activityLogData);
    }
    public function updated(Category $category): void
    {
        $activityLogData=[
            "type_of_action" => 'UPDATE',
            "entity_type" => 'Category',
            "entity_id" =>$category->id,
            "changed_fields" => $category->getChanges()
        ];
        $this->createActivityLog($activityLogData);
    }


    public function deleted(Category $category): void
    {
        $activityLogData=[
            "type_of_action" => 'DELETE',
            "entity_type" => 'Category',
            "entity_id" =>$category->id,
        ];
        $this->createActivityLog($activityLogData);
    }


    public function retrieved(Category $category): void
    {
        $activityLogData=[
            "type_of_action" => 'READ',
            "entity_type" => 'Category',
            "entity_id" =>$category->id,
        ];
        $this->createActivityLog($activityLogData);
    }

    public function creating(Category $category): void
    {
        $category->slug = Str::slug($category->name);
    }


    public function updating(Category $category): void
    {
        $category->slug = Str::slug($category->name);
    }



}
