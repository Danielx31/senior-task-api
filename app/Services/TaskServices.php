<?php

namespace App\Services;

use App\Actions\CompleteTaskAction;
use App\Actions\CreateTaskAction;
use App\Events\TaskCompleted;
use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;

class TaskServices implements TaskServiceInterface
{
    public function __construct(
        protected CreateTaskAction $createTaskAction,
        protected CompleteTaskAction $completeTaskAction
    ) {}

    public function create(array $data): Task
    {
        return $this->createTaskAction->execute($data);
    }

    public function completed(Task $task): Task
    {
        return $this->completeTaskAction->execute($task);
    }
}
