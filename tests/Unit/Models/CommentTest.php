<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Task;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class CommentTest extends BaseTestCase
{
    //
    use RefreshDatabase;

    public function test_tasks_can_have_comments() {
        $task = Task::factory()->create();

        $comment = $task->comments()->make([
            "comment" => "Task Comment"
        ]);

        $comment->user()->associate($task->user);

        $comment->save();

        $this->assertModelExists($comment);

    }

    public function test_projects_can_have_comments() {
        $project = Project::factory()->create();

        $comment = $project->comments()->make([
            "comment" => "Project Comment"
        ]);

        $comment->user()->associate($project->creator);

        $comment->save();

        $this->assertModelExists($comment);

    }

}



