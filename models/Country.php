<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    function city(){
        return $this->hasMany(City::class);
    }
}
