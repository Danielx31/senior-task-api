<?php

namespace App\Services\Contracts;

use App\DTO\TaskData;
use App\Models\Task;

interface TaskServiceInterface
{
    public function fetch(array $filters = []);

    public function create(TaskData $data): Task;

    public function completed(Task $task): Task;
}
