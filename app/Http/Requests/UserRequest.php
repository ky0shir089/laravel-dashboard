<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "uid" => "required|string",
            "name" => "required|string",
            "password" => "string",
            "fonnte_token" => "nullable|string",
            "chpass" => "required|string|in:YES,NO",
            "status" => "required|string|in:ACTIVE,INACTIVE",
            "created_by" => "integer",
            "updated_by" => "integer",
        ];
    }
}
