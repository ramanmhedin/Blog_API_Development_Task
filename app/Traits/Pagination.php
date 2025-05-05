<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

trait Pagination
{
    public function orderAndPagination( $request, Builder $query)
    {
        $orderBy = $request->get('order_by') ?? $query->getModel()->getKeyName();
        $sort = $request->get('sort', 'desc');
        $perPage = $request->get('per_page', 15);
        $page = $request->get('page')??1;

        // Apply order and pagination
        return $query->orderBy($orderBy, $sort)->simplePaginate(perPage:$perPage,page:$page);
    }
}
