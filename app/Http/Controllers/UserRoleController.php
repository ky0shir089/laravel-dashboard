<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRoleRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = UserRole::select("mst_user_roles.id", "user_id", "name", "mst_user_roles.role_id", "role_name", "user_role_status")
            ->join("users as a", "mst_user_roles.user_id", "a.id")
            ->join("mst_roles as b", "mst_user_roles.role_id", "b.id")
            ->where("user_id", $request->user_id)
            ->paginate(20);

        return new getResource($query);
    }

    public function list_role(Request $request)
    {
        $user_role = UserRole::select("role_id")->where("user_id", $request->user_id)->get();
        $role = Role::select("id", "role_name")->whereNotIn("id", $user_role)->get();

        return new getResource($role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRoleRequest $request)
    {
        $sql = User::find($request->user_id);
        $data = $request->role_id;
        $sql->roles()->attach($data, [
            "user_role_status" => $request->user_role_status,
            "created_by" => auth()->id(),
            "updated_at" => null
        ]);

        return new storeResource($sql);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        return new getResource($userRole);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(UserRoleRequest $request, UserRole $userRole)
    {
        $userRole->update($request->validated() + [
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($userRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $userRole)
    {
        $userRole->delete();

        return new deleteResource($userRole);
    }
}
