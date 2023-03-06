<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Menu::select("mst_menus.id", "menu_name", "menu_icon", "menu_route", "menu_seq", "menu_status", "module_id", "module_name")
            ->join("mst_modules as a", "mst_menus.module_id", "a.id")
            ->paginate(20);

        return new getResource($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $query = Menu::select("menu_seq")
            ->where("module_id", $request->module_id)
            ->where("menu_seq", $request->menu_seq)
            ->orderBy("menu_seq", "desc")
            ->first();

        if (!$query) {
            $sql = Menu::create($request->validated() + [
                'created_by' => auth()->id(),
                'updated_at' => null,
            ]);

            return new storeResource($sql);
        } else {
            return response()->json([
                'message' => 'Nomor sequence telah terdaftar pada module ini',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return new getResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated() + [
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return new deleteResource($menu);
    }
}
