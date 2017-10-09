<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
       'name', 'date', 'status', 'description', 'section_id'
   ];

   public function SectionTo(){
       return $this->belongsTo('App\Section', 'section_id', 'id');
   }
}
