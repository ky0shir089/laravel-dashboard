<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            "menu_name" => "required|string",
            "menu_icon" => "required|string",
            "menu_route" => "required|string",
            "menu_seq" => "required|integer",
            "menu_status" => "required|string|in:ACTIVE,INACTIVE",
            "module_id" => "required|integer|exists:mst_modules,id",
            "created_by" => "integer",
            "updated_by" => "integer",
        ];
    }
}
