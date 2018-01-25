<?php

// Home
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin'));
});

// Student Manager >
Breadcrumbs::register('student.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Student Manager', route('student.index'));
});

Breadcrumbs::register('student.show', function ($breadcrumbs, $student) {
    $breadcrumbs->parent('student.index');
    $breadcrumbs->push($student->lname, route('student.show',$student->id));
});

// Section Manager >
Breadcrumbs::register('section.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Section Manager', route('section.index'));
});

Breadcrumbs::register('section.show', function ($breadcrumbs, $section) {
    $breadcrumbs->parent('section.index');
    $breadcrumbs->push($section->name, route('section.show',$section->id));
});


// Activity Manager >
Breadcrumbs::register('activity.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Activity Manager', route('activity.index'));
});

Breadcrumbs::register('activity.show', function ($breadcrumbs, $activity) {
    $breadcrumbs->parent('activity.index');
    $breadcrumbs->push($activity->name, route('activity.show',$activity->id));
});


// Exam Manager >
Breadcrumbs::register('exam.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Exam Manager', route('exam.index'));
});

Breadcrumbs::register('exam.show', function ($breadcrumbs, $exam) {
    $breadcrumbs->parent('exam.index');
    $breadcrumbs->push($exam->name, route('exam.show',$exam->id));
});

Breadcrumbs::register('exam.show.student', function ($breadcrumbs, $student, $exam) {
    $breadcrumbs->parent('exam.show', $exam);
    $breadcrumbs->push($student->lname, route('exam.show.student',[$exam->id,$student->id]));
});
