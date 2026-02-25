<?php

namespace App\Actions;

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
        if ($task->status === 'completed') {
            throw new TaskAlreadyCompletedException();
        }

        $task->update([
            'status' => 'completed'
        ]);



        return $task;
    }
}
