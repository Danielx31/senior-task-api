<?php

namespace App\Services;

use App\Events\TaskCreated;
use App\Exceptions\TaskAlreadyCompletedException;
use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;

class TaskServices implements TaskServiceInterface
{
    public function create(array $data): Task
    {

        $task = Task::create($data);

        event(new TaskCreated($task));

        return $task;
    }

    public function completed(Task $task): Task
    {
        if ($task->status === 'completed') {
            throw new TaskAlreadyCompletedException();
        }

        $task->update([
            'status' => 'completed'
        ]);

        return $task;
    }
}
