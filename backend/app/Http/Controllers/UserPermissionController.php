<?php

namespace App\Http\Controllers;

use App\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserPermission as UpResource;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $up = UserPermission::all();

        return UpResource::collection($up);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UpResource
     */
    public function store(Request $request)
    {
        $up = new UserPermission;

        $up->user_id = $request->input('user_id');
        $up->project_id = $request->input('project_id');
        $up->permission = $request->input('permission_type_id');
        $up->accept_status = $request->input('accept_status');

        if ($up->save()) {
            return new UpResource($up);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UpResource
     */
    public function show($id)
    {
        $up = UserPermission::findOrFail($id);

        return new UpResource($up);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UpResource
     */
    public function update(Request $request, $id)
    {
        $up = UserPermission::findOrFail($id);

        $up->user_id = $request->input('user_id');
        $up->project_id = $request->input('project_id');
        $up->permission = $request->input('permission_type_id');
        $up->accept_status = $request->input('accept_status');

        if ($up->save()) {
            return new UpResource($up);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UpResource
     */
    public function destroy($id)
    {
        $up = UserPermission::findOrFail($id);

        if($up->delete()){
            return new UpResource($up);
        }
    }
}
