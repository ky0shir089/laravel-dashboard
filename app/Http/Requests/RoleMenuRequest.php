<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleMenuRequest extends FormRequest
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
            "role_id" => "integer|exists:mst_roles,id",
            "menu_id" => "array|min:1",
            "rolemenu_status" => "required|string|in:ACTIVE,INACTIVE",
            "created_by" => "integer",
            "updated_by" => "integer",
        ];
    }
}
