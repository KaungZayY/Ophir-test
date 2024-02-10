<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
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
}
