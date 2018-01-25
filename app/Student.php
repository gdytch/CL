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
        'fname', 'lname', 'password', 'section', 'path', 'avatar', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setLnameAttribute($value)
    {
        $this->attributes['lname'] = ucwords(strtolower($value));
    }

    public function setFnameAttribute($value)
    {
        $this->attributes['fname'] = ucwords(strtolower($value));
    }

    public function sectionTo()
    {
        return $this->belongsTo('App\Section', 'section', 'id');
    }

    public function Records()
    {
        return $this->hasMany('App\Record', 'student_id', 'id')->where('active', true);
    }

    public function RecordsOf($activity_id)
    {
        return $this->hasMany('App\Record', 'student_id', 'id')->where(['activity_id' => $activity_id, 'active' => true])->get();
    }


    public function scopeSearchByKeyword($query, $keyword)
    {
         if ($keyword!='') {
             $query->where(function ($query) use ($keyword) {
                 $query->where("fname", "LIKE","%$keyword%")
                     ->orWhere("lname", "LIKE", "%$keyword%");
             });
         }
         return $query;
    }

}
