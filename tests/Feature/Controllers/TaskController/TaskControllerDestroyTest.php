<?php


namespace Tests\Feature\TaskController;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



class TaskControllerDestroyTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;

    public function test_can_destroy_created_task() {

        $task = Task::factory()->create();

        Sanctum::actingAs($task->user);

        $route = route("tasks.destroy", $task);

        $response = $this->deleteJson($route);

        $response->assertNoContent();
    }
}