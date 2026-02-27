<?php

namespace App\Actions;

use App\Events\TaskCompleted;
use App\Exceptions\TaskAlreadyCompletedException;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($task) {
            if ($task->isCompleted()) {
                throw new TaskAlreadyCompletedException();
            }

            $task->update([
                'status' => 'completed'
            ]);

            DB::afterCommit(function () use ($task) {
                event(new TaskCompleted($task));
            });

            return $task->fresh();
        });
    }
}
