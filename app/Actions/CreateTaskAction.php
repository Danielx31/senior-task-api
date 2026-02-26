<?php

namespace App\Actions;

use App\Events\TaskCreated;
use App\Models\Task;

class CreateTaskAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(array $data): Task
    {
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null
        ]);

        event(new TaskCreated($task));

        return $task;
    }
}
