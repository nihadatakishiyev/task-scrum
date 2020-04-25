<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use phpDocumentor\Reflection\Project;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */


    public function index()
    {
        if(request()->query('q')){
            $users = User::where('name', 'like', ('%' .request()->query('q').'%'))->get();
            return UserResource::collection($users);
        }else{
            $users = User::all();
            return UserResource::collection($users);
        }
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('user_id'));

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(Request $request)
    {
        $user = new User;

//        $user->id = $request->input('user_id');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('user_id'));

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show($id)
    {
        $deadlines = DB::select('select id, name as \'task_name\' , deadline, \'task\' as type from tasks where owner_id ='. $id .
            ' UNION select id, name as \'project_name\', deadline, \'project\' as type from projects where owner_id = ' . $id);

        $user = User::with('tasks', 'als')->where('id', $id)->get();

        $user->push('deadlines', $deadlines);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return new UserResource($user);
        }
    }

    public function details(){
        return User::with(['project', 'project.owner','ups' => function($query){
            return $query->where('accept_status', '!=', '2');
        }, 'ups.project', 'ups.project.owner'])->where('id',Auth::id())->get();
    }
}
