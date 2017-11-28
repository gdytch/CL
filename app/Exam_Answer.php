<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_Answer extends Model
{
    protected $table = 'exam_answer';

    public $timestamps = false;


    public function ItemTo()
    {
        return $this->belongsTo('App\Exam_Item', 'exam_item_id', 'id');
    }

}
