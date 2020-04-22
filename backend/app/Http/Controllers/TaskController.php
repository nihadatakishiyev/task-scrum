<?php

namespace App\Http\Controllers;

use App\Http\Resources\Task as TaskResource;
use App\Project;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TaskResource
     */
    public function store(Request $request)
    {
        $task = $request -> isMethod('put') ? Project::findOrFail($request->task_id) : new Task;

        $task->owner_id = $request->input('owner_id');
        $task->assigned_to_id = $request->input('assigned_to_id');
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->group_id = $request->input('group_id');
        $task->is_completed = $request->input('is_completed');
        $task->deadline = $request->input('deadline');
        $task->priority_id = $request->input('priority_id');
        $task->project_id = $request->input('project_id');
        $task->label = $request->input('label');

        if($task->save()){
            return new TaskResource($task);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return TaskResource
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        //$task->load('comments');

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return TaskResource
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if($task->delete()){
            return new TaskResource($task);
        }
    }
}
