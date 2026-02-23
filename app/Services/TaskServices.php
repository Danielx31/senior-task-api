<?php

namespace App\Services;

use App\Exceptions\TaskAlreadyCompletedException;
use App\Models\Task;
use App\Services\Contracts\TaskServiceInterface;

class TaskServices implements TaskServiceInterface
{
    public function create(array $data): Task
    {
        return Task::create($data);
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
