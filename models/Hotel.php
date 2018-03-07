<?php

namespace App;
// use App\City;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    
   function city(){
    
      return  $this->belongsTo(City::class);
    }
     function discount(){
        
      return  $this->belongsToMany(Discount::class, 'hotel_discounts')->withTimestamps();
    }
     function period(){
        
      return  $this->belongsToMany(Period::class, 'hotel_periods')->withTimestamps();
    }
     function periodR(){
        
      return  $this->belongsToMany(Period::class, 'hotel_room_periods')->withPivot('number')->withTimestamps();
    }
     function room(){
        
      return  $this->belongsToMany(Room::class, 'hotel_rooms')->withPivot('roomDiscount','capacity')->withTimestamps();
    }
     function roomP(){
        
      return  $this->belongsToMany(Room::class, 'hotel_room_periods')->withPivot('number')->withTimestamps();
    }
     function service(){
        
      return  $this->belongsToMany(Service::class, 'hotel_services')->withPivot('price')->withTimestamps();
    }
     function picture(){
        
      return  $this->belongsToMany(Picture::class, 'hotel_pictures')->withTimestamps();
    }
     function comment(){
        
      return  $this->belongsToMany(Comment::class, 'hotel_costumer_comments')->withTimestamps();
    }
     function costumer(){
        
      return  $this->belongsToMany(Costumer::class, 'hotel_costumer_comments')->withTimestamps();
    }
     function odobreniKomentari(){
        
      return  $this->belongsToMany(Comment::class, 'hotel_costumer_comments')->where('status',2);
    }
}
