<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostControl extends Controller
{
    public function index(){
        return response([
            'posts'=> Post::orderBy('created_at', 'desc')->get()
        ],200);
    }
    public function store(Request $request){
        $attrs = $request->validate([
            'judul'=>'required|string',
            'content'=>'required|string'
        ]);
        // $image = $request->file('image')->store('image', 'public');
        $post = Post::create([
            'judul'=>$attrs['judul'],
            'content'=> $attrs['content'],
            'user_id'=> auth()->user()->id
        ]);
        return response([
            'post'=> $post,
            'message'=> 'Post Create SuccesFully',
        ], 200);
    }
    public function show($id){
        return response([
            'posts'=> Post::where('id', $id)->withCount('comments')->get()
        ],200);
    }
    public function update(Request $request, $id){
        $post = Post::find($id);
        if(!$post){
            return response([
                'message'=> 'Post Not Fond'
            ],403);
        }
        if($post->user_id != auth()->user()->id){
            return response([
                'message'=> 'Permission Denied'
            ],403);
        }
        $attrs = $request->validate([
            'judul'=>'required|string',
            'content'=>'required|string'
        ]);
        $post->update([
            'judul'=>$attrs['judul'],
            'content'=>$attrs['content']
        ]);
        return response([
            'message'=> 'Post Update SuccesFully',
            'post'=> $post
        ], 200);
    }
    public function destroy($id){
        $post = Post::find($id);
        if(!$post){
            return response([
                'message'=> 'Post Not Fond'
            ],403);
        }
        if($post->user_id != auth()->user()->id){
            return response([
                'message'=> 'Permission Denied'
            ],403);
        }
        $post->comments->delete();
        $post->delete();
        return response([
            'message'=> 'Post Delete Succesfully'
        ],200);
    }
}
