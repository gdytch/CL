<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_Test extends Model
{
    protected $table = 'exam_test';

    protected $fillable = [
        'exam_paper_id', 'name', 'test_type', 'description', 'number_of_items'
    ];

    public $timestamps = false;

    public function Items()
    {
        return $this->hasMany('App\Exam_Item', 'exam_test_id', 'id');
    }
}
