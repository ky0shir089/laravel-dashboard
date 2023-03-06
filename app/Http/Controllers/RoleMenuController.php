<?php

namespace App\Http\Controllers;

use App\Models\RoleMenu;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\RoleMenuRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;
use Illuminate\Support\Facades\Validator;

class RoleMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;

        $query = RoleMenu::select("mst_rolemenus.id", "role_id", "role_name", "menu_id", "menu_name", "rolemenu_status")
            ->join("mst_roles as a", "mst_rolemenus.role_id", "a.id")
            ->join("mst_menus as b", "mst_rolemenus.menu_id", "b.id")
            ->when($id, function ($query, $id) {
                return $query->where('mst_rolemenus.id', $id);
            })
            ->paginate(20);

        return new getResource($query);
    }

    public function list_menu(Request $request)
    {
        $rolemenu = RoleMenu::select("menu_id")->where("role_id", $request->role_id)->get();
        $menu = Menu::select("id", "menu_name")->whereNotIn("id", $rolemenu)->where("menu_status", "ACTIVE")->get();

        return new getResource($menu);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleMenuRequest $request)
    {
        $sql = Role::find($request->role_id);
        $data = $request->menu_id;
        $sql->menus()->attach($data, [
            "rolemenu_status" => $request->rolemenu_status,
            "created_by" => auth()->id(),
            "updated_at" => null
        ]);

        return new storeResource($sql);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoleMenu  $roleMenu
     * @return \Illuminate\Http\Response
     */
    public function show(RoleMenu $roleMenu)
    {
        return new getResource($roleMenu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoleMenu  $roleMenu
     * @return \Illuminate\Http\Response
     */
    public function update(RoleMenuRequest $request, RoleMenu $roleMenu)
    {
        $roleMenu->update([
            'rolemenu_status' => $request->rolemenu_status,
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($roleMenu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoleMenu  $roleMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleMenu $roleMenu)
    {
        $roleMenu->delete();

        return new deleteResource($roleMenu);
    }
}
