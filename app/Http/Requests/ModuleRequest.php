<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            "module_name" => "required|string",
            "module_icon" => "required|string",
            "module_seq" => "required|integer",
            "created_by" => "integer",
            "updated_by" => "integer",
        ];
    }
}
