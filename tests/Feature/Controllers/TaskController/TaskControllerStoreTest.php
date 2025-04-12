<?php


namespace Tests\Feature\TaskController;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



class TaskControllerStoreTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;

    public function test_can_create_task() {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $route = route("tasks.store");

        $response = $this->postJson($route, [
            "title" => "foo"

        ]);

        $response->assertCreated();

        $this->assertDatabaseHas("tasks",[
            "title" => "foo",
            "user_id" => $user->id

        ]);
    }

    public function test_title_is_required() {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $route = route("tasks.store");

        $response = $this->postJson($route, []);

        $response->assertJsonValidationErrors([
            "title" => "required"
        ]);

    }


    public function test_cannot_create_tasks_for_unknown_projects() {

        $project = Project::factory()->create();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $route = route("tasks.store");

        $response = $this->postJson($route, [
            "title" => "title",
            "project_id" => $project->id
        ]);

        $response->assertJsonValidationErrors([
            "project_id" => "in"
        ]);

    }

}