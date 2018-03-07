<?php

namespace App\Http\Controllers;
use App\HotelCostumerComment;
use Illuminate\Http\Request;
use App\Comment;
use App\Reply;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class FormController extends Controller
{
    function comment(Request $request){
        $comment= new Comment;
        $comment->comment= $request->comment;
        if($request->user()->isAdmin()){
             $comment->status= 2;
        }else{
    
        $comment->status= 1;
        }
        $comment->save();
        $hotelCostumerComment=new HotelCostumerComment;
        $hotelCostumerComment->costumer_id= Auth::user()->id;
        $hotelCostumerComment->comment_id= $comment->id;
        $hotelCostumerComment->hotel_id= $request->hotel;
        $hotelCostumerComment->save();
      return response()->json($comment);
    }
     function reply(Request $request, Comment $comment){
    $reply= new Reply;
        
        $reply->reply= $request->reply;
        $reply->costumer_id=Auth::user()->id;
   
       $reply->comment_id=$comment->id;
        if(Auth::user()->admin==1){
            $reply->status=2;
        }else{
        $reply->status=1;
        }
        $reply->save();
      
        return response()->json($reply);
    }
}
