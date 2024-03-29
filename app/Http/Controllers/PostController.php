<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    public function index(){
        $posts = Post::latest()->paginate();
        $posts->load('user');
        return view('dashboard',compact('posts'));
    }

    public function create(){
        return view('posts.post-create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required|string',
            'body'=>'required|string'
        ]);

        $posted=$request->user()->posts()->create([
            'title'=>$request->title,
            'body'=>$request->body
        ]);
        if (!$posted) {
            return back()->with('error', 'Cannot Upload at the moment');
        } else {
            return redirect()->route('dashboard')->with('success', 'Upload successful');
        }
    }

    public function edit(Post $post){
        Gate::authorize('edit-delete-post',$post);
        return view('posts.post-edit',compact('post'));
    }

    public function update(Request $request, Post $post){
        Gate::authorize('edit-delete-post',$post);
        $this->validate($request,[
            'title'=>'required|string',
            'body'=>'required|string'
        ]);

        $updated=$post->update([
            'title'=>$request->title,
            'body'=>$request->body,
        ]);

        if (!$updated) {
            return back()->with('error', 'Cannot Update at the moment');
        } else {
            return redirect()->route('dashboard')->with('success', 'Updated successfully');
        }
    }

    public function destroy(Post $post){
        Gate::authorize('edit-delete-post',$post);
        $deleted = $post->delete();
        if(!$deleted)
        {
            return redirect()->route('dashboard')->with('error','Cannot Delete this Post');
        }
        else
        {
            return redirect()->route('dashboard')->with('success', 'You had Deleted the Post'); 
        }
    }

    public function detail(Post $post){
        $comments = $post->comments()->latest()->with('user')->paginate();
        return view('posts.post-detail',compact('post','comments'));
    }
}
