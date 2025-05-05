<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    

    public function index(CategoryRequest $request,CategoryService $categoryService): JsonResponse
    {
        $validData=$request->validated();
        try {
            $data=$categoryService->index($validData);
            return $this->successResponse($data,"categories retrieved successfully");
        }catch (\Exception $exception)
        {
            return $this->serverErrorResponse($exception,"retrieving categories failed");
        }
    }

    public function show($id,CategoryService $categoryService): JsonResponse
    {
        try {
            $data=$categoryService->show($id);
            return $this->successResponse($data,"category retrieved successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Category not found");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"retrieving category failed");
        }
    }

    public function store(CategoryRequest $request,CategoryService $categoryService): JsonResponse
    {
        $validData=$request->validated();

        try {
            $data=$categoryService->store($validData);
            return $this->successResponse($data,"category created successfully");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"creating category failed");
        }
    }

    public function update(CategoryRequest $request,$id, CategoryService $categoryService): JsonResponse
    {
        $validData=$request->validated();

        //check if the id is not text
        if (!is_numeric($id)) {
            return $this->errorResponse("Invalid category ID");
        }

        try {
            $data=$categoryService->update($validData,$id);
            return $this->successResponse($data,"category updated successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Category not found");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"updating category failed");
        }
    }

    public function destroy($id, CategoryService $categoryService): JsonResponse
    {

        try {
            $data=$categoryService->destroy($id);
            return $this->successResponse($data,"category deleted successfully");

        }catch (ModelNotFoundException) {
            return $this->notFoundResponse("Category not found");

        }catch (\Exception $exception) {
            return $this->serverErrorResponse($exception,"deleting category failed");
        }
    }

}
