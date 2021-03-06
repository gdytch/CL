<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	 protected $fillable = [
        'name', 'path', 'status'
    ];

    public function Students()
	{
        return $this->hasMany('App\Student', 'section', 'id');
    }

	public function Activities()
	{
		return $this->hasMany('App\Activity', 'section_id', 'id');
	}
}
