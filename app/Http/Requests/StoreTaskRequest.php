<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            "title" => ["required", "max:255"],
            "schedule_at" => ["nullable", "date"],
            "due_at" => ["nullable", "date"],
            // i think u can use a policy here
            "project_id" => ["nullable", Rule::in(Auth::user()->memberships->pluck("id"))
            ]

        ];
    }
}
