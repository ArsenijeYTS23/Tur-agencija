<?php

namespace App\Http\Controllers\admin;
use App\Costumer;
// use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\HotelCostumerComment;
use App\Hotel;
use App\Reply;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    function show(){ 
        $comments=  Comment::all();
        return view('admin/comments', compact('comments'));
    }
    function aproove(Comment $comment){
       Comment::where('id',$comment->id)
               ->update(['status'=>2]);
       return response()->json($comment);
    }
    function delete(Comment $comment){
        Reply::where('comment_id',$comment->id)
                ->delete();
        HotelCostumerComment::where('comment_id',$comment->id)
                ->delete();
       Comment::where('id',$comment->id)
               ->delete();
      return response()->json($comment);
    }
}
