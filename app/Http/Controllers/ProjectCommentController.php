<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ProjectCommentController extends Controller
{
    //

    public function index(Request $request, Project $project) {
        $comments = $project->comments()->orderByDesc("created_at")->paginate();

        return new CommentCollection($comments);
        

    }
    public function store(StoreCommentRequest $request, Project $project) {
        $validated = $request->validated();

        $comment = $project->comments()->make($validated);

        $comment->user()->associate(Auth::user());

        $comment->save();

        return new CommentResource($comment);
    }
}

