<?php

namespace App\Http\Controllers;
use App\Hotel;
use Illuminate\Http\Request;
use App\City;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Room;
use App\Period;
use App\Service;
use App\HotelRoomPeriod;
use App\Arrangment;
use App\Costumer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use App\Reply;


class HotelController extends Controller
{
   function show($country, $grad, Hotel $hotel){
       $hotel= $hotel->load('picture')
            ->load('room')
            ->load('period')
            ->load('service')
            ->load('comment.costumer')
            ->load('city.country');  

       
 if(!empty(Arrangment::where('created_at','<', Carbon::now()->subMinutes(1) )->where('status',1))){
     $arrangments= Arrangment::where('created_at','<', Carbon::now()->subMinutes(1) )
             ->where('status',1)->get();
              $data = ['data'=>'aaaaa'];
                  if(isset($arrangments)){
               foreach ($arrangments as $arrangment){
        Mail::send('emails.test', $data,  function ($message) use ($arrangment) {
        $message->to($arrangment->costumer->email);
                            });
         $hrperiod= new HotelRoomPeriod;
       $hrperiod
               ->where('room_id',$arrangment->room_id)
               ->where('hotel_id',$arrangment->hotel_id)
               ->where('period_id',$arrangment->period_id)
               ->decrement('number');
              Arrangment::where('id',$arrangment->id)->delete();
                            }
                          }
                        }
         $predsezona=date('y-m-d',strtotime($hotel->preseason));
       $postsezona=date('y-m-d',strtotime($hotel->postseason));
                 if(isset($hotel->period)){
                   foreach($hotel->period as $period){
                   $od=date('y-m-d',strtotime($period->from));
                  $do=date('y-m-d',strtotime($period->toto));
                $popustPre= date_diff(date_create($od),date_create($predsezona))->format("%R%a");
                        if($popustPre<0){
                           $popustPre=0;
                             }
                 $popustPos= date_diff(date_create($postsezona),date_create($do))->format("%R%a");
   if($popustPos<0){
         $popustPos=0;
     }
   $ukupnoDana= date_diff(date_create($od),date_create($do))->format("%R%a");
   $k=$ukupnoDana-$popustPre-$popustPos;
   if($k<0 && $popustPre==0){
       $k=0;
       $popustPos=$ukupnoDana;
   }
   if($k<0 && $popustPos==0){
       $k=0;
       $popustPre=$ukupnoDana;
   }
  $koeficijent=($popustPre*($hotel->predis)+($k)+$popustPos*($hotel->postdis))/$ukupnoDana;
  $period->setAttribute('periodKoef',$koeficijent);
        }}
        if(!empty($hotel->comment())){
  $hotel->setAttribute('brKomentara',$hotel->comment()->where('status', 2)->get()->count());
  $hotel->setAttribute('comment',$hotel->comment()->where('status', 2)->get());
        }
  return view('blog-item', compact('hotel'));
    }
    
    
    
    
    
    
    function comment($country, $city, $motel, Hotel $hotel){
   $hotel->setAttribute('comment',$hotel->odobreniKomentari()
           ->get());
     return view('comment', compact('hotel'));
    }
    
    
    
    
    function rezervisi(Hotel $hotel, Room $room, Period $period, Service $service, $price){
       $roomPeriodKAPACITET= $room->hotel()
               ->where('hotel_id',$hotel->id)
               ->first()
               ->pivot
               ->capacity;
         $hotelRoomPeriodZAUZETE=HotelRoomPeriod::where('hotel_id',$hotel->id)->where('room_id',$room->id)->where('period_id',$period->id)->first()->number;
 if(!empty(Auth::user()) && $hotelRoomPeriodZAUZETE<$roomPeriodKAPACITET){
 HotelRoomPeriod::where('hotel_id',$hotel->id)->where('room_id',$room->id)->where('period_id',$period->id)->update(['number'=>$hotelRoomPeriodZAUZETE+1]);
    
   $arrangement= new Arrangment;
    $arrangement->hotel_id=$hotel->id;     
    $arrangement->room_id=$room->id;     
    $arrangement->period_id=$period->id;
    $arrangement->service_id=$service->id;
    $arrangement->price=$price;
    $arrangement->costumer_id=Auth::user()->id;
    $arrangement->status=1;
    $arrangement->save();
         }
         return back();
    }
}
