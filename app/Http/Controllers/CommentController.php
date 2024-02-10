<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post){
        $this->validate($request,[
            'text'=>'required|string'
        ]);

        $userId = $request->user()->id;
        $commented=$post->comments()->create([
            'user_id'=>$userId,
            'text'=>$request->text,
        ]);
        if (!$commented) {
            return back()->with('error', 'Cannot Upload at the moment');
        } else {
            return redirect()->route('post.detail',$post->id)->with('success', 'Upload successful');
        }
    }
}
