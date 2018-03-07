<?php

namespace App\Http\Controllers\Admin;
use App\Country;
use Illuminate\Http\Request;
use App\City;
use Intervention\Image\Facades\Image; 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CityPicture;
use App\Hotel;
use Carbon\Carbon;
use App\HotelRoom;
use App\HotelService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class FormController extends Controller
{
   

    public function country() {
        return view('admin/country');
    }
    public function saveCountry(Request $request) {
     $rules = array(
    'country'    => 'required', 
);
    $this->validate($request, $rules);
        
        
        
        $country= new Country;
         $country->name= $request->country;
        $country->save();
        return back();
    }
    public function city() {
      $countries= Country::get();
        return view('admin/city', compact('countries'));
    }
    public function saveCity(Request $request) {
      $rules = array(
    'country'    => 'required', 
    'city'    => 'required', 
);
       $this->validate($request, $rules);
       
       
        $city= new City;
         $city->name= $request->city;
         $city->carriage= $request->prevoz;
         $city->country_id=$request->country;
        $city->save();
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
      public function hotel() {
      $cities= City::orderBy('name')->get();
        return view('admin/hotel', compact('cities'));
    }
       function saveHotel(Request $request) {
           
             $rules = array(
    'hotel'    => 'required', 
    'price'    => 'required', 
    'preseason'    => 'required', 
    'postseason'    => 'required', 
    'predis'    => 'required', 
    'postdis'    => 'required', 
    'onedis'    => 'required', 
    'twodis'    => 'required', 
    'threedis'    => 'required', 
    'fourdis'    => 'required', 
    'br1'    => 'required', 
    'br2'    => 'required', 
    'br3'    => 'required', 
    'br4'    => 'required', 
    'polu'    => 'required', 
    'pun'    => 'required', 
    'all'    => 'required', 
);
       $this->validate($request, $rules);
       
           
           
        $hotel= new Hotel;
         $hotel->name= $request->hotel;
         $hotel->price= $request->price;
         $hotel->city_id=$request->city;
         $hotel->preseason=Carbon::parse($request->preseason)->format('Y-m-d');
         $hotel->postseason=Carbon::parse($request->postseason)->format('Y-m-d');
         $hotel->predis=(100-$request->predis)/100;
         $hotel->postdis=(100-$request->postdis)/100;
          $hotel->description=$request->description;
           $hotel->save();
           
           
           $discounts=[['onedis','br1'],['twodis','br2',],['threedis','br3',],['fourdis','br4']];
           $i=1;
           foreach ($discounts as $dis){
        if($request->$dis[0]){
            $hotelRoom= new HotelRoom;
          $hotelRoom->hotel_id=$hotel->id;  
          $hotelRoom->room_id=$i;  
          $hotelRoom->roomDiscount=(100-$request->$dis[0])/100;
          $hotelRoom->capacity=$request->$dis[1];
          $hotelRoom->save();
          $i++;
           }}
           $serv=[0,'polu','pun','all'];
           $k=1;
           foreach($serv as $se){
           $hotelService=new HotelService;
           $hotelService->hotel_id=$hotel->id;
           $hotelService->service_id=$k;
           $hotelService->price=$request->$se;
           $hotelService->save();
           $k++;
           }
      return back();
    }
}
