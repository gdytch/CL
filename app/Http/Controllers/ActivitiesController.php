<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Section;
use App\Student;
use App\Activity;
use App\Record;
use App\FTRule;

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
        $rules = FTRule::all();
        $active = null;
        $section_activities = array();
        $today = date("Y-m-d", time());
        if ($request->get('active')) {
            $active = $request->get('active');
        }


        foreach($sections as $section)
        {
            if(count($section->Activities) == 0)
            {
                $section_activities[$section->id] = null;
            }else {
                $activities1 = null;
                $student_no = count($section->Students);
                $activity_list = $section->Activities()->orderBy('created_at', 'desc')->get();
                foreach ($activity_list as $activity)
                {
                    $activities1[] = (object) array(
                        'id'            => $activity->id,
                        'name'          => $activity->name,
                        'description'   => $activity->description,
                        'date'          => $activity->date,
                        'section_id'    => $section->id,
                        'section'       => $section->name,
                        'activity_rule' => $activity->FTRule->extensions,
                        'submit_count'  => count($activity->Records()->distinct()->get(['student_id']))."/".$student_no,
                        'active'        => $activity->active,
                        'submission'    => $activity->submission,
                    );
                }
                $section_activities[$section->id] = $activities1;
            }
        }

        $variables = array(
            'dashboard_content'  => 'dashboards.admin.activity.index',
            'sections'           => $sections,
            'active'             => $active,
            'filetype_rules'     => $rules,
            'section_activities' => $section_activities,
            'today'              => $today,
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
        if (count($result) > 0) {
            return redirect()->back()->withError('Activity already exist');
        }

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
        $sections = Section::all();
        $rules    = FTRule::all();
        $students = $activity->SectionTo->Students()->orderBy('lname', 'asc')->get();
        $post     = $activity->Post;
        $activityStats = (object) array(
                'submitted'    => 0,
                'notsubmitted' => 0
        );

        // student who have are done with the activity\

        foreach ($students as $key => $student) {
            $status = false;
            $submitted_at = null;
            $result = $student->Records()->where('activity_id', $activity->id)->get()->first();
            if (count($result)) {
                $status = true;
                $submitted_at = date("M d Y", strtotime($result->created_at));
                $activityStats->submitted += 1;
            }
            else {
                $activityStats->notsubmitted +=1;
            }
            $activity_log[] = (object) array(
                'id'           => $student->id,
                'name'         => $student->lname.', '.$student->fname,
                'status'       => $status,
                'submitted_at' => $submitted_at,
                'session'      => app('App\Http\Controllers\AdminsController')->sessionStatus($student)
            );
        }



        $variables = array(
            'dashboard_content' => 'dashboards.admin.activity.show',
            'activity'          => $activity,
            'activity_log'      => $activity_log,
            'post'              => $post,
            'sections'          => $sections,
            'filetype_rules'    => $rules,
            'activityStats'     => $activityStats
        );

        return view('layouts.admin')->with($variables);
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

        $result = Activity::where(['name' => $request->name, 'section_id' => $request->section_id])->get()->first();
        if (count($result) > 0 && $id != $result->id) {
            return redirect()->back()->withError('Activity name already exist');
        }

        $activity =  Activity::find($id);
        $activity->update($request->all());

        return redirect()->back()->withSuccess('Acitivity updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $activity = Activity::find($id);
        $activity->delete();

        return redirect('admin/activity?active='.$activity->SectionTo->id)->withSuccess('Activity deleted');
    }



    public function changeStatus($id)
    {

        $activity = Activity::find($id);

        if ($activity->active) {
            $activity->active = false;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withError('Status: INACTIVE - '.$activity->name.'');
        } else {
            $activity->active = true;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withSuccess('Status: ACTIVE - '.$activity->name.'');
        }
    }



    public function changeSubmissionStatus($id)
    {

        $activity = Activity::find($id);

        if ($activity->submission) {
            $activity->submission = false;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withError('Submission: CLOSED - '.$activity->name.'');
        } else {
            $activity->submission = true;
            $activity->save();
            return redirect('admin/activity?active='.$activity->SectionTo->id)->withSuccess('Submission: OPEN - '.$activity->name.'');
        }
    }
}
