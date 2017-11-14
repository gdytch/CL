<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_Paper extends Model
{
    protected $table = 'exam_paper';

    protected $fillable = [
        'name', 'description', 'number_of_test', 'perfect_score'
    ];

    public $timestamps = false;

    public function Tests()
    {
        return $this->hasMany('App\Exam_Test', 'exam_paper_id', 'id');
    }

}
