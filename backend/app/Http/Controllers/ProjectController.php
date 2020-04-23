<?php

namespace App\Http\Controllers;

use App\Http\Resources\Project as ProjectResource;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $projects = Project::all();

        return ProjectResource::collection($projects);
    }

    public function update(Request $request, $id) {
        $project = Project::findOrFail($id);

        $project->owner_id = $request->input('owner_id');
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->color_code = $request->input('color_code');
        $project->is_completed = $request->input('is_completed');
        $project->deadline = $request->input('deadline');

        if($project->save()){
            return new ProjectResource($project);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ProjectResource
     */
    public function store(Request $request)
    {
        $project = new Project;

        $project->owner_id = $request->input('owner_id');
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->color_code = $request->input('color_code');
        $project->is_completed = $request->input('is_completed');
        $project->deadline = $request->input('deadline');

        if($project->save()){
            return new ProjectResource($project);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return ProjectResource
     */
    public function show($id)
    {
        $project = Project::with('owner', 'tasks')->where('id', $id)->get();
//        $project->load('tasks');
//        dd($project);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return ProjectResource
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->delete()){
            return new ProjectResource($project);
        }
    }
}
