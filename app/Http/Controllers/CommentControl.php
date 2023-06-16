<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
class CommentControl extends Controller
{
    public function index($id){
        $post = Post::find($id);
        if(!$post){
            return response([
                'message'=> 'Post Not Found'
            ],403);
        }
        return response([
            'comment'=> $post->comments()->with('user:id,name')->get()
        ],200);
    }
    public function store(Request $request, $id){
        $post = Post::find($id);
        if(!$post){
            return response([
                'message'=> 'Post Not Found'
            ],403);
        }
        $attrs = $request->validate([
            'comment'=> 'required|string'
        ]);
        Comment::create([
            'comment'=>$attrs['comment'],
            'post_id'=>$id,
            'user_id'=> auth()->user()->id
        ]);
        return response([
            'message'=> 'Comment Created Succesfully'
        ],200);
    }
    public function update(Request $request, $id){
        $comment = Comment::find($id);
        if(!$comment){
            return response([
                'message'=> 'Comment Not Found'
            ],403);
        }
        // if($comment != auth()->user()->id){
        //     return response([
        //         'message'=> 'Permission Denied'
        //     ]);
        // }
        $attrs = $request->validate([
            'comment'=> 'required|string'
        ]);
        $comment->update([
            'comment'=>$attrs['comment']
        ]);
        return response([
            'message'=> 'Comment Updated Successfully'
        ],200);
    }
    public function destroy($id){
        $comment = Comment::find($id);
        if(!$comment){
            return response([
                'message'=> 'Comment Not Found'
            ],403);
        }
        // if($comment != auth()->user()->id){
        //     return response([
        //         'message'=> 'Permission Denied'
        //     ]);
        // }
        $comment->delete();
        return response([
            'message'=> 'Comment Deleted Successfully'
        ], 200);
    }
}
