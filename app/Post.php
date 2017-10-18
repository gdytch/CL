<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title', 'body', 'draft'
    ];

    public function Activities()
    {
        return $this->hasMany('App\Activity' , 'post_id', 'id');
    }
}
