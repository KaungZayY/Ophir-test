<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function edit(Comment $comment){
        Gate::authorize('edit-comment',$comment);
        return view('comments.comment-edit',compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        $this->validate($request,[
            'text'=>'required|string'
        ]);

        $updated=$comment->update([
            'text'=>$request->text,
        ]);
        if (!$updated) {
            return back()->with('error', 'Cannot Update the comment');
        } else {
            return redirect()->route('post.detail',$comment->post_id)->with('success', 'Update successful');
        }
    }

    public function destroy(Comment $comment){
        $post = $comment->post;

        //wrap as array because of authorize method behaviour, first arg as gate name & second as param
        Gate::authorize('delete-comment',[$comment, $post]);
        
        $deleted = $comment->delete();
        if(!$deleted)
        {
            return redirect()->back()->with('error','Cannot Delete this Comment');
        }
        else
        {
            return redirect()->back()->with('success', 'You had Deleted the Comment'); 
        }
    }
}
