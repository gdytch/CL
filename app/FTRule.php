<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FTRule extends Model
{

    protected $table = 'ftrules';

    protected $fillable = [
        'name', 'icon', 'extensions', 'icon'
    ];

    public $timestamps = false;


}
