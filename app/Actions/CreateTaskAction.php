<?php

namespace App\Actions;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {
            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null
            ]);

            DB::afterCommit(function () use ($task) {
                event(new TaskCreated($task));
            });

            return $task->fresh();
        });
    }
}
