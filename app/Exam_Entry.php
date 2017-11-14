<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_Entry extends Model
{
    protected $table = 'exam_entry';

    public $timestamps = false;

    public function Exam_Paper($id)
    {
        $exam = Exam::find($id);
        return Exam_Paper::find($exam->exam_paper_id);
    }

    public function StudentTo()
    {
        return $this->hasOne('App\Student', 'student_id', 'id');
    }
}
