<?php

namespace App\Services\Contracts;

use App\Models\Task;

interface TaskServiceInterface
{
    public function create(array $data): Task;

    public function completed(Task $task): Task;
}
