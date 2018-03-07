<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
   function hotel(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_periods')->withTimestamps();
    }
   function hotelR(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_room_periods')->withPivot('number')->withTimestamps();
    }
}
