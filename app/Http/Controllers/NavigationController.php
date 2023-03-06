<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserRole::select("c.id", "module_name", "module_icon", "module_seq")
            ->join("mst_rolemenus as a", "mst_user_roles.role_id", "a.role_id")
            ->join("mst_menus as b", "a.menu_id", "b.id")
            ->join("mst_modules as c", "b.module_id", "c.id")
            ->with(['menus' => function ($q) use ($request) {
                $q->select("module_id", "mst_menus.id", "menu_icon", "menu_name", "menu_route", "menu_seq")
                    ->where("a.user_id", $request->user_id);
            }])
            ->where("mst_user_roles.user_id", $request->user_id)
            ->where("mst_user_roles.user_role_status", 'ACTIVE')
            ->groupBy('id')
            ->orderBy('module_seq', 'asc')
            ->get();

        return response()->json([
            'message' => 'Success',
            'data' => $query
        ], 200);
    }
}
