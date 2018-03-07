<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    function hotel(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_rooms')->withPivot('roomDiscount','capacity')->withTimestamps();
    }
    function hotelP(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_room_periods')->withPivot('number')->withTimestamps();
    }
}
