<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Task extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "title",
        "is_done",
        "project_id",
        "scheduled_at",
        "due_at"
    ];

    protected $casts = [
        "is_done" => "boolean"
    ];



    

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }


    public function comments() {
        return $this->morphMany(Comment::class, "commentable");
    }



    // only tasks created by a user can be viewed by the user
    protected static function booted() {
        static::addGlobalScope("member", function(Builder $builder) {
            $builder->where("user_id", Auth::id())
            ->orWhereIn("project_id", Auth::user()->memberships->pluck("id"));

        });
    }



    
}
