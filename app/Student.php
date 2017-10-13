<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;


class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'password', 'section', 'path', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function sectionTo(){
        return $this->belongsTo('App\Section', 'section', 'id');
    }

    public function Records(){
        return $this->hasMany('App\Record', 'student_id', 'id');
    }

    public function RecordsOf($activity_id)
    {
        return $this->hasMany('App\Record', 'student_id', 'id')->where('activity_id', $activity_id)->get();
    }

}
