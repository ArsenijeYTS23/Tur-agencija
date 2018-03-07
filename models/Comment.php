<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    function aproove(){
        return $this->status==="2";
    }
    function costumer(){
        
      return  $this->belongsToMany(Costumer::class, 'hotel_costumer_comments');
    }
    function hotel(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_costumer_comments');
    }
    function reply(){
        
      return  $this->hasMany(Reply::class);
    }
   
}
