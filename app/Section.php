<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	 protected $fillable = [
        'fname', 'lname', 'password', 'section', 'path', 'avatar',
    ];
    
    public function students(){
        return $this->hasMany('App\Student', 'id', 'section');
    }
}
