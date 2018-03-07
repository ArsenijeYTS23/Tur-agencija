<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Country;
use App\Http\Requests;
use App\City;

class CountryController extends Controller
{
    function home(){
    $country=Country::first();
    return redirect(url('country/'.$country->name, $country->id ));
     
    }
    function show($drzava, Country $country){
 
    $cities=City::where('country_id',$country->id)->paginate(2);

        return view('blog', compact('cities','country'));
    }
}
