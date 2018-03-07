<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
   function hotel(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_discounts')->withTimestamps();
    }
}
