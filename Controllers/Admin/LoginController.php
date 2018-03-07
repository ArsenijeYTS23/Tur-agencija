<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Costumer;

class LoginController extends Controller
{
  
      function show(){
        return view('admin/login');
    }
      function reg(){
        return view('admin/register');
    }
  public function doLogin(Request $request)
{
   //   $user=  auth()->guard('users');
// validate the info, create rules for the inputs
$rules = array(
    'email'    => 'required|email', // make sure the email is an actual email
   // 'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
);

// run the validation rules on the inputs from the form
$validator = Validator::make(Input::all(), $rules);

// if the validator fails, redirect back to the form
if ($validator->fails()) {
    return Redirect::to('login')
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('email')); // send back the input (not the password) so that we can repopulate the form
} else {
 if(isset(User::where('name', '=' , $request->get('name'))->where('email','=',$request->get('email'))->first()->id)){
  $user = User::where('name', '=' , $request->get('name'))->where('email','=',$request->get('email'))->first()->id;
  }else{
      $user=0;
    // attempt 
  }
    // attempt to do the login
    if (Auth::loginUsingId($user)) {

      return Auth::user();
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
