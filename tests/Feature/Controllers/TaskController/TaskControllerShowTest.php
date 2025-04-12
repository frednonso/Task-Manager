<?php


namespace Tests\Feature\TaskController;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



class TaskControllerShowTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;

    public function test_can_see_created_tasks() {
        

        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        Sanctum::actingAs($user);

        $route = route("tasks.show", $task);

        $response = $this->getJson($route);

        $response->assertOk()
        ->assertJson([
            "data" => [
                "id" => $task->id,
                "title" => $task->title,
                "is_done" => $task->is_done,
                "status" => "open",
                "project_id" => null,
                "user_id" => $user->id,
                "created_at" => $task->created_at->jsonSerialize(), 
                "updated_at" => $task->updated_at->jsonSerialize()
            ]
        ]);
    }


    public function test_unauthenticated_response() {

        $task = Task::factory()->create();

        $route = route("tasks.show", $task);

        $response = $this->getJson($route);

        $response->assertUnauthorized();



    }

    public function test_no_access_response() {
        $user = User::factory()->create();

        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $route = route("tasks.show", $task);

        $response = $this->getJson($route);

        $response->assertNotFound();




    }



}