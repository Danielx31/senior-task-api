<?php

namespace App\Actions;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;

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
        $page = request('page', 1);

        $key = "tasks_" . md5(json_encode($filters)) . "_page_" . $page;

        return Cache::remember($key, 60, function () use ($filters) {
            return Task::select(['id', 'title', 'status', 'created_at'])
                ->when($filters['status'] ?? null, function ($query, $status) {
                    if ($status === 'completed') {
                        $query->completed();
                    }
                })
                ->when($filters['search'] ?? null, function ($query, $search) {
                    $query->search($search);
                })
                ->latest()
                ->paginate();
        });
    }
}
