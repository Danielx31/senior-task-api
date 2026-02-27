<?php

namespace App\Actions;

use App\Models\Task;

class FetchTaskAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(array $filters = [])
    {
        $query = Task::query();

        if (!empty($filters['status'])) {
            $query->where('is_completed', $filters['status'] === 'completed' ? true : false);
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate(10);
    }
}
