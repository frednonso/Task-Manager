<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;




class ProjectController extends Controller
{
    //
    

    public function index (Request $request) {

        $projects = QueryBuilder::for(Project::class)->allowedIncludes("tasks")->paginate();

        return new ProjectCollection($projects);

    }


    public function store(StoreProjectRequest $request) {
        $validated = $request->validated();

        $project = Auth::user()->projects()->create($validated);

        return new ProjectResource($project);



    }

    public function show(Request $request, Project $project) {

        Gate::authorize("view", $project);
        return (new ProjectResource($project))->load("tasks")->load("members");

    }


    public function update(UpdateProjectRequest $request, Project $project) {

        $validated = $request->validated();

        Gate::authorize("update", $project);

        $project->update($validated);

        return new ProjectResource($project);


    }

    public function destroy(Request $request, Project $project) {

        Gate::authorize("delete", $project);

        $project->delete();

        return response()->noContent();

    }
}
