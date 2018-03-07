<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    function cityPicture(){
        return $this->hasMany(CityPicture::class);
    }
    function hotel(){
        return $this->hasMany(Hotel::class);
    }
    function country(){
        return $this->belongsTo(Country::class);
    }
}
