<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
       'name', 'date', 'status', 'description', 'section_id', 'post_id'
   ];

   public function SectionTo()
   {
       return $this->belongsTo('App\Section', 'section_id', 'id');
   }

   public function Records()
   {
       return $this->hasMany('App\Record', 'activity_id', 'id')->where('active', true);
   }

   public function Post(){
       return $this->hasOne('App\Post' , 'id', 'post_id')->where('draft', false);
   }

}
