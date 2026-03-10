<?php

namespace App\Actions;

use App\DTO\TaskData;
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

    public function execute(TaskData $data): Task
    {
        return DB::transaction(function () use ($data) {
            // $task = Task::create((array) $data); //Optional

            $task = Task::create([
                'title' => $data->title,
                'description' => $data->description,
                'status' => $data->status,
                'user_id' => $data->user_id
            ]); // Safer

            DB::afterCommit(function () use ($task) {
                event(new TaskCreated($task));
            });

            return $task->fresh();
        });
    }
}
