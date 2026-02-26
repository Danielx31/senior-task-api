<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Jobs\SendTaskCompletedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCompletedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompleted $event): void
    {
        SendTaskCompletedJob::dispatch($event->task);
    }
}
