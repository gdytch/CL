<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Section;
use App\Student;
use App\Activity;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();

        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.activity.index')->with('sections', $sections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Activity::where(['name' => $request->name, 'section_id' => $request->section_id])->get();
        if(count($result) > 0)
            return redirect()->back()->withError('Activity already exist');

        $activity = new Activity($request->all());
        $activity->save();
        return redirect()->back()->withSuccess('Activity added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);

        $students = $activity->SectionTo->Students;

        // student who have are done with the activity

        foreach ($students as $key => $student) {
            $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$activity->name."*";
            $contents = File::glob($directory);
            if($contents != null)
                $status = true;
           else
                $status = false;
           $activity_log[] = (object) array('id' => $student->id, 'name' => $student->lname.', '.$student->fname, 'status' => $status);
        }

        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.activity.show')->with('activity', $activity)->with('activity_log', $activity_log);
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
