<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    protected TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create($request->validated());

        return $this->success($task, 'Task created successfully', 201);
    }

    public function completed(Task $task)
    {
        $task = $this->taskService->completed($task);

        return $this->success($task, 'Task marked as completed successfully');
    }
}
