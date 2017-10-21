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

    public function Activities()
    {
        return $this->hasMany('App\Activity', 'ftrule_id', 'id');
    }
}
