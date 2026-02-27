<?php

namespace Tests\Unit;

use App\Actions\CompleteTaskAction;
use App\Events\TaskCompleted;
use App\Exceptions\TaskAlreadyCompletedException;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CompleteTaskActionTest extends TestCase
{
    use RefreshDatabase;

    protected CompleteTaskAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = $this->app->make(CompleteTaskAction::class);
    }

    /** @test */
    public function task_can_be_completed()
    {
        Event::fake();

        $task = Task::factory()->create([
            'status' => 'pending'
        ]);

        $completedTask = $this->action->execute($task);

        $this->assertEquals('completed', $completedTask->status);

        Event::assertDispatched(TaskCompleted::class, function ($event) use ($completedTask) {
            return $event->task->id === $completedTask->id;
        });
    }

    /** @test */
    public function completing_already_completed_task_throws_exception()
    {
        $this->expectException(TaskAlreadyCompletedException::class);

        $task = Task::factory()->create([
            'status' => 'completed'
        ]);

        $this->action->execute($task);
    }
}
