<?php

namespace App\Actions;

use App\Events\TaskCompleted;
use App\Exceptions\TaskAlreadyCompletedException;
use App\Models\Task;

class CompleteTaskAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(Task $task): Task
    {
        if ($task->isCompleted()) {
            throw new TaskAlreadyCompletedException();
        }

        $task->update([
            'status' => 'completed'
        ]);

        event(new TaskCompleted($task));

        return $task;
    }
}
