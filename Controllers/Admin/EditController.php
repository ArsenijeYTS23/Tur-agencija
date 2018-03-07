<?php

namespace App\Http\Controllers\admin;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\City;
use Intervention\Image\Facades\Image; 
use App\CityPicture;
use App\Hotel;
use Carbon\Carbon;
use App\HotelPicture;
use App\Picture;
use App\Room;
use App\HotelRoom;
use App\Period;
use App\HotelPeriod;
use App\HotelRoomPeriod;
use App\HotelService;

class EditController extends Controller
{
    function country(){
        $countries=Country::all();
        return view('admin/editCountry',compact('countries'));
    }
    function updateCountry(Country $country){
        
        return view('admin/updateCountry',compact('country'));
    }
    function changeCountry(Request $request, Country $country){
        $request->country;
             DB::table('countries')
            ->where('id', $country->id)
            ->update(['name' => $request->country]);
        return back();
    }
    function deleteCountry(Country $country){
           DB::table('countries')->where('id', '=', $country->id)
                   ->delete();
        return back();
    }
    function city(){
        $cities=City::all();
        return view('admin/editCity',compact('cities'));
    }
    function updateCity(City $city){
       $countries=Country::all();
        return view('admin/updateCity',compact('city', 'countries'));
    }
    function deleteImageCity(City $city){
      if(isset($city->cityPicture)){
            CityPicture::where('city_id','=',$city->id)->delete();
           }
           if(\File::exists('images/city/'.$city->id)){
         \File::cleanDirectory('images/city/'.$city->id);
         \File::deleteDirectory('images/city/'.$city->id);
     
    }
     return back();
           }
    function updateImageCity(Request $request, City $city){
        if($request->hasFile('slika')){
        \File::makeDirectory('images/city/'.$city->id, $mode = 0777, true, true);
        Image::make($request->file('slika'))->resize(300, 200)->save('images/city/'.$city->id.'/'.(CityPicture::count()+1).'.jpg');
       $cityPicture= new CityPicture;
        $cityPicture->city_id=$city->id;
        $cityPicture->name=(CityPicture::count()+1).'.jpg';
        $cityPicture->save();
        }
      return back();
    }
            function changeCity(Request $request, City $city){
    
             DB::table('cities')
            ->where('id', $city->id)
            ->update(['name' => $request->city,'carriage' => $request->prevoz,'country_id' => $request->country]);
        return back();
    }
    function deleteCity(City $city){
   
          
           if(isset($city->cityPicture)){
            CityPicture::where('city_id','=',$city->id)->delete();
           }
          if(\File::exists('images/city/'.$city->id)){
         \File::cleanDirectory('images/city/'.$city->id);
         \File::deleteDirectory('images/city/'.$city->id);
           }
            City::where('id', '=', $city->id)->delete();
        return back();
    }
     function hotel(){
        $hotels=Hotel::all();
        return view('admin/editHotel',compact('hotels'));
    }
    function updateHotel(Hotel $hotel){
   
       $cities=City::all();
        return view('admin/updateHotel',compact('hotel', 'cities'));
    }
      function changeHotel(Request $request, Hotel $hotel){
   
             DB::table('hotels')
            ->where('id', $hotel->id)
            ->update(['name' => $request->hotel,'price' => $request->price,'preseason' => Carbon::parse($request->preseason)->format('Y-m-d'),
                'postseason' =>Carbon::parse($request->postseason)->format('Y-m-d'),'predis' => (100-$request->predis)/100,
                'postdis' => (100-$request->postdis)/100,'description' => $request->description,'city_id' => $request->city]);
            //  HotelRoom::where('hotel_id',$hotel->id)->where('room_id',1)->update(['roomDiscount'=>(100-$request->twodis)/100]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',2)->update(['roomDiscount'=>(100-$request->twodis)/100]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',3)->update(['roomDiscount'=>(100-$request->threedis)/100]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',4)->update(['roomDiscount'=>(100-$request->fourdis)/100]);
              HotelService::where('hotel_id',$hotel->id)->where('service_id',2)->update(['price'=>$request->polu]);
              HotelService::where('hotel_id',$hotel->id)->where('service_id',3)->update(['price'=>$request->pun]);
              HotelService::where('hotel_id',$hotel->id)->where('service_id',4)->update(['price'=>$request->all]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',1)->update(['capacity'=>$request->br1]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',2)->update(['capacity'=>$request->br2]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',3)->update(['capacity'=>$request->br3]);
              HotelRoom::where('hotel_id',$hotel->id)->where('room_id',4)->update(['capacity'=>$request->br4]);
             return back();
         
    }
    function updateImageHotel(Request $request, Hotel $hotel){
      
        if($request->hasFile('slika')){
              \File::makeDirectory('images/hotel/'.$hotel->id, $mode = 0777, true, true);
              foreach($request->file('slika') as $slika){
        Image::make($slika)->resize(300, 200)->save('images/hotel/'.$hotel->id.'/'.(HotelPicture::count()+1).'.jpg');
        $picture=new Picture;
        $picture->picture=(HotelPicture::count()+1).'.jpg';
        $picture->save();
       $hotelPicture= new HotelPicture;
        $hotelPicture->hotel_id=$hotel->id;
        $hotelPicture->picture_id=$picture->id;
        $hotelPicture->name=(HotelPicture::count()+1).'.jpg';
        $hotelPicture->save();
        }}
        return back();
    }
     function deleteImageHotel(Hotel $hotel, Picture $picture){
          \File::delete('images/hotel/'.$hotel->id.'/'.$picture->picture);
     $hotelPicture=new HotelPicture;
      $hotelPicture->where('picture_id',$picture->id)->where('hotel_id',$hotel->id)->delete();
       $picture->where('id',$picture->id)->delete();
      
       
      
      return back();
    }
     function deleteHotel(Hotel $hotel){
   
    if(\File::exists('images/city/'.$hotel->id)){
          \File::cleanDirectory('images/hotel/'.$hotel->id);
         \File::deleteDirectory('images/hotel/'.$hotel->id);
    }
    if(isset($hotel->picture)){
         foreach($hotel->picture as $picture){
             Picture::where('id','=',$picture->id)->delete();
         }
               HotelPicture::where('hotel_id','=',$hotel->id)->delete();
        
    } 
    if(isset($hotel->period)){
         foreach($hotel->period as $period){
             Period::where('id','=',$period->id)->delete();
         }
              
    } 
        HotelRoomPeriod::where('hotel_id',$hotel->id)->delete();
        HotelPeriod::where('hotel_id',$hotel->id)->delete();
       HotelRoom::where('hotel_id', '=', $hotel->id)->delete();
       HotelService::where('hotel_id', '=', $hotel->id)->delete();
       Hotel::where('id', '=', $hotel->id)->delete();
       
        return back();
    }
    function dateHotel(Request $request, Hotel $hotel){
      //  return $hotel->room;
       if(Carbon::parse($request->od)<Carbon::parse($request->do)){
       
        if(!empty($request->od) && !empty($request->do)){
        $period= new Period;
        $period->from= Carbon::parse($request->od)->format('Y-m-d');
        $period->toto= Carbon::parse($request->do)->format('Y-m-d');
        $period->save();
       $hotelperiod=new HotelPeriod;
       $hotelperiod->hotel_id=$hotel->id;
       $hotelperiod->period_id=$period->id;
        $hotelperiod->save();
        }
        foreach($hotel->room as $room){
        $hrp= new HotelRoomPeriod;
        $hrp->room_id=$room->id;
        $hrp->hotel_id=$hotel->id;
        $hrp->period_id=$period->id;
        $hrp->number=0;
        $hrp->save();
        }
       }
       
         return back();
    }
    function deleteDate(Hotel $hotel, Period $period){
        HotelRoomPeriod::where('period_id',$period->id)->delete();
        HotelPeriod::where('period_id',$period->id)->delete();
        $period->delete();
        return back();
    }
}
