<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ProjectCommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/login", [AuthController::class, "login"]);

Route::post("/register", [AuthController::class, "register"]);

// Route::apiResource("tasks", TaskController::class)->middleware("auth:sanctum");

Route::middleware("auth:sanctum")->group(function() {
    Route::apiResource("tasks", TaskController::class);
    Route::apiResource("projects", ProjectController::class);
    Route::apiResource("projects.members", MembersController::class)->only([
        "index", "store", "destroy"
    ]);
    // Route::apiResource("projects.comments", CommentController::class)->only([
    //     "index", "store"
    // ]);
    // Route::apiResource("tasks.comments", CommentController::class)->only([
    //     "index", "store"
    // ]);

    Route::get("/projects/{project}/comments", [ProjectCommentController::class, 'index'])->name("projects.comments.index");;
    Route::get('/tasks/{task}/comments', [TaskCommentController::class, 'index'])->name("tasks.comments.index");

    Route::post("/projects/{project}/comments", [ProjectCommentController::class, 'store'])->name("projects.comments.store");;
    Route::post('/tasks/{task}/comments', [TaskCommentController::class, 'store'])->name("tasks.comments.store");

});

// Route::get("/tasks", [TaskController::class, "index"]);


