<?php

namespace Tests\Unit;

use App\Actions\CreateTaskAction;
use App\Events\TaskCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateTaskActionTest extends TestCase
{
    use RefreshDatabase;

    protected CreateTaskAction $action;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->action = $this->app->make(CreateTaskAction::class);
    }

    /** @test */
    public function task_can_be_created()
    {
        Event::fake();

        $data = [
            'title' => 'learn Laravel Testing',
            'description' => 'Write unit tests for actions',
        ];

        $task = $this->action->execute($data);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $data['title'],
            'status' => 'pending',
        ]);

        $this->assertEquals($data['title'], $task->title);

        Event::assertDispatched(TaskCreated::class, function ($event) use ($task) {
            return $event->task->id === $task->id;
        });
    }

    /** @test */
    public function task_can_be_created_without_description()
    {
        Event::fake();

        $data = [
            'title' => 'Task without description',
        ];

        $task = $this->action->execute($data);

        $this->assertEquals($data['title'], $task->title);
        $this->assertNull($task->description);

        Event::assertDispatched(TaskCreated::class, function ($event) use ($task) {
            return $event->task->id === $task->id;
        });
    }
}
