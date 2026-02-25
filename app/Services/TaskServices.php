<?php

namespace App\Services;

use App\Actions\CompleteTaskAction;
use App\Actions\CreateTaskAction;
use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Exceptions\TaskAlreadyCompletedException;
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

        $task = $this->createTaskAction->execute($data);

        event(new TaskCreated($task));

        return $task;
    }

    public function completed(Task $task): Task
    {
        $completedTask = $this->completeTaskAction->execute($task);

        event(new TaskCompleted($completedTask));

        return $completedTask;
    }
}
