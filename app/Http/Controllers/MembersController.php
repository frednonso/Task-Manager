<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class MembersController extends Controller
{
    //
    public function index(Request $request, Project $project) {
        $members = $project->members;

        return new UserCollection($members);

    }

    public function store(Request $request, Project $project) {
        $request->validate([
            "user_id" => ["required", "exists:users,id"]
        ]);

        // wont attach user twice to the project members

        $project->members()->syncWithoutDetaching([$request->user_id]);

        $members = $project->members;

        return new UserCollection($members);

    }


    public function destroy(Request $request, Project $project, int $member) {
        // u can use a policy here
        abort_if($project->user_id === $member, 400, "Cannot remove creator from project");

        // Gate::authorize("delete", $member);


        $project->members()->detach([$member]);

        $member = $project->members;

        return new UserCollection($member);

    }
}

