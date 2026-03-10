<?php

namespace App\Services;

use App\Actions\CompleteTaskAction;
use App\Actions\CreateTaskAction;
use App\Actions\FetchTaskAction;
use App\DTO\TaskData;
use App\Events\TaskCompleted;
use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;

class TaskServices implements TaskServiceInterface
{
    public function __construct(
        protected FetchTaskAction $fetchTaskAction,
        protected CreateTaskAction $createTaskAction,
        protected CompleteTaskAction $completeTaskAction
    ) {}

    public function fetch(array $filters = [])
    {
        return $this->fetchTaskAction->execute($filters);
    }

    public function create(TaskData $data): Task
    {
        return $this->createTaskAction->execute($data);
    }

    public function completed(Task $task): Task
    {
        return $this->completeTaskAction->execute($task);
    }
}
