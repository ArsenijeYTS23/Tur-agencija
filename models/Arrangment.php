<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arrangment extends Model
{
    function costumer(){
        return $this->belongsTo(Costumer::class);
    }
    function period(){
        return $this->belongsTo(Period::class);
    }
    function service(){
        return $this->belongsTo(Service::class);
    }
    function room(){
        return $this->belongsTo(Room::class);
    }
    function hotel(){
        return $this->belongsTo(Hotel::class);
    }
}
