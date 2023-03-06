<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query =  User::select("users.id", "uid", "name", "status")
            ->with("user_roles:user_id,mst_user_roles.id,role_id,role_name,user_role_status")
            ->when($search, function ($query, $search) {
                return $query->where('uid', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            })
            ->paginate(10);

        return new getResource($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $sql = User::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'fonnte_token' => $request->fonnte_token,
            'password' => Hash::make(12345678),
            'chpass' => $request->chpass,
            'status' => $request->status,
            'created_by' => auth()->id(),
            'updated_at' => null,
        ]);

        return new storeResource($sql);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new getResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->chpass == "YES") {
            $password = Hash::make(12345678);
        } else {
            $password = $user->password;
        }

        $user->update($request->validated() + [
            'password' => $password,
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return new deleteResource($user);
    }
}
