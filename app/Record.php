<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function StudentTo()
    {
        return $this->belongsTo('App\Student', 'student_id', 'id');
    }

    public function ActivityTo()
    {
        return $this->belongsTo('App\Activity', 'activity_id', 'id');
    }
}
