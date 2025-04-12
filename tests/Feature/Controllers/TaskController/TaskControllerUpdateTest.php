<?php


namespace Tests\Feature\TaskController;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



class TaskControllerUpdateTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;

    public function test_can_update_title() {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $task = Task::factory()->for($user)->create();

        $route = route("tasks.update", $task);

        $response = $this->putJson($route, [
            "title" => "foo",
        ]);

        $response->assertOk();





    }







    // public function test_cannot_update_as_project_member() {
    //     $user = User::factory()->create();

    //     $project = Project::factory()->create();

    //     $project->members()->attach([$user->id]);

    //     $task = Task::factory()->for($project->creator)->for($project)->create();

    //     Sanctum::actingAs($user);
 
    //     $route = route("tasks.update", $task);

    //     $response = $this->putJson($route,[
    //         "title" => "foo",

    //     ]);

    //     $response->assertForbidden();
    // }


    public function test_unauthenticated_response()
    {
       
        $task = Task::factory()->create();

        $route = route("tasks.update", $task);

        $response = $this->putJson($route, [
            "title" => "foo",
        ]);

        $response->assertUnauthorized();

    }


    public function test_no_access_response() {



        $user = User::factory()->create();

        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $route = route("tasks.update", $task);

        $response = $this->putJson($route, [
            "title" => "foo",
        ]);

        $response->assertNotFound();
    }

}