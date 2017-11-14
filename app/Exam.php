<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
            'name', 'description', 'exam_paper_id', 'section_id'
    ];

    public function SectionTo()
    {
        return $this->belongsTo('App\Section', 'section_id', 'id');
    }

    public function ExamPaper()
    {
        return $this->hasOne('App\Exam_Paper', 'id', 'exam_paper_id');
    }
}
