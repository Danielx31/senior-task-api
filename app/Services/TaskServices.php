<?php

namespace App\Services;

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
            return $task;
        }

        $task->update([
            'status' => 'completed'
        ]);

        return $task;
    }
}
