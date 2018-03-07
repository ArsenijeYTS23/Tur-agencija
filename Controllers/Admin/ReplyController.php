<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Reply;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Support\Facades\Input;

class ReplyController extends Controller
{
    function reply(Request $request, Comment $comment){
    $reply= new Reply;
        
        $reply->reply= $request->reply;
        $reply->costumer_id=Auth::user()->id;
     //   $reply->comment_id= $request->kom;
       $reply->comment_id=$comment->id;
        if(Auth::user()->admin==1){
            $reply->status=2;
        }else{
        $reply->status=1;
        }
        $reply->save();
      
        return response()->json($reply);
    }
    function delete(Reply $reply){
        Reply::where('id',$reply->id)->delete();
       return response()->json($reply);
    }
    function aproove(Reply $reply){
         Reply::where('id',$reply->id)->update(['status'=>2]);
        return response()->json($reply);
    }
}
