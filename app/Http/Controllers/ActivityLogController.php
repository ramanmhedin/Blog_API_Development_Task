<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityLogRequest;
use App\Services\ActivityLogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    use ApiResponse;

    public function index(ActivityLogRequest $request,ActivityLogService $activityLogService): JsonResponse
    {
        $validData=$request->validated();
        try {
            $activityLogs=$activityLogService->index($validData);
            return $this->successResponse($activityLogs,"activity logs retrieved successfully ");

        }catch (\Exception $exception){
            return $this->serverErrorResponse($exception,'retrieving activity logs failed');
        }
    }
}
