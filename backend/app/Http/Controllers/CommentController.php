<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Routing\Controller;
use phpDocumentor\Reflection\Types\Collection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $comment = Comment::all();
        return CommentResource::collection($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResource
     */
    public function store(Request $request)
    {
        $comment = $request -> isMethod('put') ? Comment::findOrFail($request->comment_id) : new Comment;

        $comment->task_id = $request->input('task_id');
        $comment->commenter_id = $request->input('commenter_id');
        $comment->content = $request->input('content');
        $comment->is_deleted = $request->input('is_deleted');

        if($comment->save()){
            return new CommentResource($comment);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CommentResource
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->load('commenter');
        return new CommentResource($comment);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return CommentResource
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if($comment->delete()){
            return new CommentResource($comment);
        }
    }
}
