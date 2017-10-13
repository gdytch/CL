<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Section;
use App\Student;
use App\Activity;
use App\Record;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sections = Section::all();
        if($request->get('active'))
            $active = $request->get('active');
        else
            $active = null;
        $variables = array(
            'dashboard_content' => 'dashboards.admin.activity.index',
            'sections' => $sections,
            'active' => $active,
        );
        return view('layouts.admin')->with($variables);
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
        return redirect('admin/activity?active='.$request->section_id)->withSuccess('Activity added');
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
            $status = false;
            $submitted_at = null;

            $result = $student->Records()->where('activity_id', $activity->id)->get()->first();
            if(count($result)){
                $status = true;
                $submitted_at = date("M d Y", strtotime($result->created_at));
            }
            $activity_log[] = (object) array('id' => $student->id, 'name' => $student->lname.', '.$student->fname, 'status' => $status, 'submitted_at' => $submitted_at);
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

    public function changeStatus($id){
        $activity = Activity::find($id);

        if($activity->active){
            $activity->active = false;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withError('Status: INACTIVE - '.$activity->name.'');
        }
        else{
            $activity->active = true;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withSuccess('Status: ACTIVE - '.$activity->name.'');
        }
    }
}
