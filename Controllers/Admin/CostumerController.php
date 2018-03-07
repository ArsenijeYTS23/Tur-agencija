<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Costumer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class CostumerController extends Controller
{
   function show(){
      $costumers= Costumer::all();
      return view('admin.costumer', compact('costumers'));
   }
   function makeAdmin(Costumer $costumer){
       Costumer::where('id',$costumer->id )
               ->update(['admin'=>1]);
       return back();
   }
   function delete(Costumer $costumer){
       Costumer::where('id',$costumer->id )
               ->delete();
       return back();
   }
   function imageSave(Request $request){
        if($request->hasFile('slika')){
              \File::makeDirectory('images/costumers/'.Auth::user()->id, $mode = 0777, true, true);
              Image::make($request->file('slika'))->resize(150, 100)->save('images/costumers/'.Auth::user()->id.'/'.Auth::user()->id.'.jpg');
              Costumer::where('id',Auth::user()->id)->update(['image'=>(Auth::user()->id.'.jpg')]);
        }
        return back();
   }
   function imageDelete(){
        if(\File::exists('images/costumers/'.Auth::user()->id)){
         \File::cleanDirectory('images/costumers/'.Auth::user()->id);
         \File::deleteDirectory('images/costumers/'.Auth::user()->id);
     
    }
       Costumer::where('id',Auth::user()->id)->update(['image'=>0]);
        return back();
   }
   function slika(){
 
       return view('admin/slika', compact('a'));
   }
}
