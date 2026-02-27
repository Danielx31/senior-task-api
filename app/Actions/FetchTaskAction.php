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
        return Task::query()
            ->when($filters['status'] ?? null, function ($query, $status) {
                if ($status === 'completed') {
                    $query->completed();
                }
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->search($search);
            })
            ->latest()
            ->paginate(10);
    }
}
