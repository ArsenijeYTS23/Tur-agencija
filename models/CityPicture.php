<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityPicture extends Model
{
    function city(){
    return $this->belongsTo(City::class);
}
}