<?php


namespace Tests\Feature\CommentController;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;



class CommentStoreTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;

    public function test_can_create_comments_for_tasks() {

        $task = Task::factory()->create();

        Sanctum::actingAs($task->user);

        $route = route("tasks.comments.store", $task);

        $response = $this->postJson($route, [
            "comment" => "foo"
        ]);

        $response->assertCreated();


    }


    public function test_can_create_comments_for_projects() {

        $project = Project::factory()->create();

        Sanctum::actingAs($project->user);

        $route = route("projects.comments.store", $project);

        $response = $this->postJson($route, [
            "comment" => "bar"
        ]);

        $response->assertCreated();


    }

}