<?php

namespace App\Http\Middleware;

use App\UserPermission;
use App\Project;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $splittd= explode('/', $request->getRequestUri());
        $project_id = $splittd[sizeof($splittd)-1];
        $projects = Project::where([['owner_id', $user->id], ['id' , $project_id]])->pluck('id');
        $ups = UserPermission::where([['user_id', $user->id], ['project_id' , $project_id],['accept_status', 1]])->pluck('project_id');
//        dd($ups);
//        return !$projects->isEmpty() || !$ups->isEmpty();
        $check = !$projects->isEmpty() || !$ups->isEmpty();
//        dd($ups);
        if($check){
            return $next($request);
        }else{
            return response(['message' => 'You are not allowed to see this project.'], 301);
        }
    }
}
