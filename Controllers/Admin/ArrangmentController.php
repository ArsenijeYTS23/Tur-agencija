<?php

namespace App\Http\Controllers\admin;
use App\Arrangment;
use Illuminate\Http\Request;
use App\HotelRoomPeriod;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArrangmentController extends Controller
{
    function show(){
        
   $arrangments=  Arrangment::all();
  
        return view('admin/arrangments', compact('arrangments'));
}
function potvrdi(Arrangment $arrangment){
    Arrangment::where('id',$arrangment->id)->update(['status'=>2]);
  
    return back();
}
function obrisi(Arrangment $arrangment){
   
    HotelRoomPeriod::where('hotel_id',$arrangment->hotel->id)
            ->where('room_id',$arrangment->room->id)
            ->where('period_id',$arrangment->period->id)
            ->decrement('number');
         
    
    
    Arrangment::where('id',$arrangment->id)->delete();
  
    return back();
}
}
