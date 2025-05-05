<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    use ApiResponse;

    public function index(PostRequest $request,PostService $postService): JsonResponse
    {
        $validData=$request->validated();
        try {
            $data=$postService->index($validData);
            return $this->successResponse($data,"posts retrieved successfully");
        }catch (\Exception $exception)
        {
            return $this->serverErrorResponse($exception,"retrieving posts failed");
        }
    }

    public function show($id,PostService $postService): JsonResponse
    {
        try {
            $data=$postService->show($id);
            return $this->successResponse($data,"post retrieved successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Post not found");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"retrieving post failed");
        }
    }

    public function store(PostRequest $request,PostService $postService): JsonResponse
    {
        $validData=$request->validated();

        try {
            $data=$postService->store($validData);
            return $this->successResponse($data,"post created successfully");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"creating post failed");
        }
    }

    public function update(PostRequest $request,$id, PostService $postService): JsonResponse
    {
        $validData=$request->validated();

        try {
            $data=$postService->update($validData,$id);
            return $this->successResponse($data,"post updated successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Post not found");

        }catch (UnauthorizedException) {
            return $this->unauthorizedResponse("action unauthorized");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"updating post failed");
        }
    }

    public function destroy($id, PostService $postService): JsonResponse
    {

        try {
            $data=$postService->destroy($id);
            return $this->successResponse($data,"post deleted successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Post not found");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"deleting post failed");
        }
    }
}
