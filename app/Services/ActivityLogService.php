<?php

namespace App\Services;


use App\Models\ActivityLog;
use App\Traits\Pagination;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogService{

    use Pagination;
    public function index($validData)
    {
        $query=ActivityLog::query()
            ->with('performerUser')
            ->when(isset($validData['search']),
                fn($q) => $q->where('performer','ILIKE','%'.$validData['search']."%")
            )
            ->when(isset($validData['type_of_action']),
                fn($q) => $q->where('type_of_action',$validData['type_of_action'])
            )
            ->when(isset($validData['entity_type']),
                fn($q) => $q->where('entity_type',$validData['entity_type'])
            )
            ->when(isset($validData['entity_id']),
                fn($q) => $q->where('entity_id',$validData['entity_id'])
            )
            ->when(isset($validData['from_date']) && isset($validData['to_date']),
                fn(Builder $q) => $q->whereBetween('timestamp',
                    [$validData['from_date']." 00:00:00",$validData['to_date']." 23:59:59"])
            );

        return $this->orderAndPagination($validData,$query);
    }
}
