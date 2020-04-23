<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\ActivityLog as AlResource;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $als = ActivityLog::all();
        return AlResource::collection($als);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AlResource
     */
    public function store(Request $request)
    {
        $al = new ActivityLog;

        $al->action_name = $request->input('action_name');
        $al->owner_id = $request->input('owner_id');

        if ($al->save()){
            return new AlResource($al);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return AlResource
     */
    public function show($id)
    {
        $al = ActivityLog::findOrFail($id);

        return new AlResource($al);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return AlResource
     */
    public function update(Request $request, $id)
    {
        $al = ActivityLog::findOrFail($id);

        $al->action_name = $request->input('action_name');
        $al->owner_id = $request->input('owner_id');

        if ($al->save()){
            return new AlResource($al);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return AlResource
     */
    public function destroy($id)
    {
        $al = ActivityLog::findOrFail($id);

        if($al->delete()){
            return new AlResource($al);
        }
    }
}
