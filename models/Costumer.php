<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Costumer extends Authenticatable
{
   //   protected $guard = 'costumers';
     protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    function isAdmin(){
       if($this->admin==1){
           return true;
       }
           return false;
       
    }
    function isSuperAdmin(){
       if($this->superAdmin==1){
           return true;
       }
           return false;
       
    }
    
  function comment(){
        
      return  $this->belongsToMany(Comment::class, 'hotel_costumer_comments');
    }
  function hotel(){
        
      return  $this->belongsToMany(Hotel::class, 'hotel_costumer_comments');
    }
    function reply(){
          return  $this->hasMany(Reply::class);
    }
   
   
}
