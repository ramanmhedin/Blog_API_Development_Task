<?php

namespace App\Services;

use App\Models\Post;
use App\Traits\Pagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class PostService
{
    use Pagination;
    public function index($validData)
    {
        $query=Post::query()
            ->with(['category:id,name','author:id,name'])
            ->when(isset($validData['search']),
                fn($q) => $q->where('title','ILIKE','%'.$validData['search']."%")
            )
            ->when(isset($validData['category_id']),
                fn($q) => $q->where('category_id','ILIKE',$validData['category_id'])
            )
            ->when(isset($validData['category_slug']),
                function (Builder $query) use($validData){
                $query->whereHas('category',
                    fn($q) => $q->where('slug',$validData['category_slug']));}
            )
            ->when(isset($validData['from_date']) && isset($validData['to_date']),
                fn(Builder $q) => $q->whereBetween('created_at',
                    [$validData['from_date']." 00:00:00",$validData['to_date']." 23:59:59"])
            );

        return $this->orderAndPagination($validData,$query);
    }

    public function show($id)
    {
        return Post::query()
            ->with(['category','author'])
            ->findOrFail($id);
    }

    public function store($validData)
    {
        $validData['author_id'] = Auth::id();
        return Post::query()
            ->create($validData);
    }
    public function update($validData,$id)
    {
        $post=Post::query()->findOrFail($id);

        if(Auth::id() != $post->author_id){
            throw (new UnauthorizedException);
        }
        $post->update($validData);
        return $post;
    }
    public function destroy($id)
    {
        $post=Post::query()->findOrFail($id);

        if(Auth::id() != $post->author_id){
            throw (new UnauthorizedException);
        }

        $post->delete();
        return $post;
    }

}
