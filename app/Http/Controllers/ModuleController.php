<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleRequest;
use App\Http\Resources\deleteResource;
use App\Http\Resources\getResource;
use App\Http\Resources\storeResource;
use App\Http\Resources\updateResource;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Module::orderBy('module_seq', 'asc')->paginate(20);

        return new getResource($query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        $sql = Module::create($request->validated() + [
            'created_by' => auth()->id(),
            'updated_at' => null,
        ]);

        return new storeResource($sql);
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $id)
    {
        return new getResource($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $id)
    {
        $id->update($request->validated() + [
            'updated_by' => auth()->id(),
        ]);

        return new updateResource($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $id)
    {
        $id->delete();

        return new deleteResource($id);
    }
}
