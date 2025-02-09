<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        "title"
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }

    public function members() {
        return $this->belongsToMany(User::class, Member::class);
    }

    // protected static function booted() {
    //     static::addGlobalScope("member", function(Builder $builder) {
    //         $builder->whereRelation("members", "user_id", Auth::id());

    //     });
    // }

    

}
