<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Costumer;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\User;

use Illuminate\Support\Facades\Redirect;
 use Auth;

class LoginController extends Controller
{
 //    protected $table = 'costumers';
    function login(){
        return view('login');
    }
   
    function out(){
      Auth::logout();
        return back();
    }
    public function logg(Request $request)
{
       
                    $rules = array(
           'email'    => 'required|email', // make sure the email is an actual email
  //  'password' => 'required|alphaNum|min:3'
);

// run the validation rules on the inputs from the form
$validator = Validator::make($request->all(), $rules);

// if the validator fails, redirect back to the form
if ($validator->fails()) {
   
    return Redirect::to('login')
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('email')); // send back the input (not the password) so that we can repopulate the form
} else {
  if(isset(Costumer::where('name', '=' , $request->get('name'))->where('email','=',$request->get('email'))->first()->id)){
  $costumer = Costumer::where('name', '=' , $request->get('name'))->where('email','=',$request->get('email'))->first()->id;
  }else{
      $costumer=0;
  }
    // attempt to do the login
    if (Auth::loginUsingId($costumer)) {

    //  return Auth::user();
        return back();

    } else {        
   
   //    return  Auth::loginUsingId(1);
  // return  $user = Auth::user();
        // validation not successful, send back to form 
        return Redirect::to('login');

    }

}
}
}
