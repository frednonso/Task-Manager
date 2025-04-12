<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class TaskCommentController extends Controller
{
    //

    public function index(Request $request, Task $task) {
        $comments = $task->comments()->orderByDesc("created_at")->paginate();

        return new CommentCollection($comments);


    }







    public function store(StoreCommentRequest $request, Task $task) {
        $validated = $request->validated();

        $comment = $task->comments()->make($validated);

        $comment->user()->associate(Auth::user());

        $comment->save();

        return new CommentResource($comment);
    }
}

