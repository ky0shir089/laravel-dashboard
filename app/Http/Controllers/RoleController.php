<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Role::select("id", "role_name")->paginate(20);

        return new getResource($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $sql = Role::create([
            'role_name' => $request->role_name,
            'created_by' => auth()->id(),
            'updated_at' => null,
        ]);

        return new storeResource($sql);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new getResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update([
            'role_name' => $request->role_name,
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return new deleteResource($role);
    }
}
