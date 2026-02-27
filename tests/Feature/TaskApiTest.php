<?php

namespace Tests\Feature;

use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    /** @test */
    public function it_can_create_task_via_api()
    {
        Event::fake();

        $payload = [
            'title' => 'Learning API Testing',
            'description' => 'Test the CreatTaskAction via HTTP'
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Task created successfully',
                'data' => [
                    'title' => 'Learning API Testing'
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Learning API Testing'
        ]);

        Event::assertDispatched(TaskCreated::class);
    }

    /** @test */
    public function it_can_complete_task_via_api()
    {
        Event::fake();

        $task = Task::factory()->create([
            'status' => 'pending'
        ]);

        $response = $this->patchJson("/api/v1/tasks/{$task->id}/completed");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Task marked as completed successfully',
                'data' => [
                    'id' => $task->id,
                    'status' => 'completed'
                ],
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed',
        ]);

        Event::assertDispatched(TaskCompleted::class, function ($event) use ($task) {
            return $event->task->id === $task->id;
        });
    }
}
