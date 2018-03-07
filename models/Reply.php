<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    function comment(){
        
      return  $this->belongsTo(Comment::class);
    }
    function costumer(){
        
      return  $this->belongsTo(Costumer::class);
    }
}
