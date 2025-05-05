<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\Pagination;

class CategoryService
{
    use Pagination;
    public function index($validData)
    {
        $query=Category::query()
            ->when(isset($validData['search']),
                fn($q) => $q->where('name','ILIKE','%'.$validData['search']."%"));

        return $this->orderAndPagination($validData,$query);
    }

    public function show($id)
    {
        return Category::query()
            ->findOrFail($id);
    }

    public function store($validData)
    {
        return Category::query()
            ->create($validData);
    }
    public function update($validData,$id)
    {
        $category=Category::query()->findOrFail($id);

        $category->update($validData);
        return $category;

    }
    public function destroy($id)
    {
        $category=Category::query()->findOrFail($id);
        $category->delete();
        return $category;
    }

}
