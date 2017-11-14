<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exam_Answer;

class Exam_Item extends Model
{
    protected $table = 'exam_item';

    public $timestamps = false;

    protected $fillable = [
        'exam_paper_id', 'exam_test_id', 'correct_answer', 'question', 'points'
    ];

    public function Test()
    {
        return $this->belongsTo('App\Exam_Test', 'exam_test_id', 'id');
    }

    public function Choices()
    {
        return $this->hasMany('App\Exam_Item_Choice', 'exam_item_id', 'id');
    }


    
}
