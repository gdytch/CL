<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Section;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.student.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.student.create')->with('sections', $sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lname = ucwords($request->lname);
        $fname = ucwords($request->fname);
        $path = ''.$lname.'-'.$fname.'';
        $avatar = 'default-avatar.png';
        $password = $request->password;
        $section = $request->section;
        
        $student = new Student();
        $student->lname = $lname;
        $student->fname = $fname;
        $student->path = $path;
        $student->avatar = $avatar;
        $student->password = $password;
        $student->section = $section;
        $student->save();

        return redirect()->route('student.index')->withSuccess('Student Added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
