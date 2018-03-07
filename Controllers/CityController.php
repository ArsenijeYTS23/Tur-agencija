<?php

namespace App\Http\Controllers;
use App\Hotel;
use Illuminate\Http\Request;
use App\City;
use App\Http\Requests;
use App\Country;
class CityController extends Controller
{
    function show($country, City $city){
         $hotels= Hotel::where('city_id',$city->id)->paginate(3);
         return view('blog1', compact('city','hotels'));
    }
}
