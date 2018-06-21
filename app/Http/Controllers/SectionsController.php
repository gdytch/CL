<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Section;
use App\Record;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: stats for section
        $sections = Section::all();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.section.index',
            'sections' => $sections
        );

        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.section.index')->with('sections', $sections);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('layouts.admin')->with('dashboard_content' ,'dashboards.admin.section.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->Validate($request, [
            'name' => 'unique:sections'
        ]);

        $section = new Section();
        $section->name = strtoupper($request->name);
        $section->path = strtoupper($request->path);
        $section->status = 0;
        $section->save();

        $path = '/storage'.'/'.$section->path;
        if (!Storage::exists($path))
            Storage::makeDirectory($path,0777,true);

        return redirect()->route('section.index')->withSuccess('Section Added.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $section = Section::find($id);
        $students = $section->Students;
        $activities = $section->Activities;

        foreach($students as $key => $student){
            $activity_table[$student->id] = array();
            foreach($activities as $activity){
                $activity_table[$student->id][$activity->id] = $this->checkActivity($student, $activity);
            }
        }

        foreach ($activities as $key => $activity) {
            $activityStats[$key] = (object) array(
                'activity_name'  => $activity->name,
                'submitted'      => 0,
                'notsubmitted'   => 0,
            );
            foreach ($students as $key1 => $student) {
                if($this->getActivityStats($student, $activity)){
                    $activityStats[$key]->submitted += 1;
                }
                else
                    $activityStats[$key]->notsubmitted +=1;
            }
        }
        $variables = array(
            'dashboard_content' => 'dashboards.admin.section.show',
            'section'           => $section,
            'students'          => $students,
            'activities'        => $activities,
            'activity_table'    => $activity_table,
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

        $section = Section::find($id);

        $variables = array(
            'dashboard_content' => 'dashboards.admin.section.edit',
            'section' => $section
        );
        return view('layouts.admin')->with($variables);

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

        $section = Section::find($id);
        // if($section->path != $request->path){
        //     File::move(public_path()."\\storage\\".$section->path, public_path().'\\storage\\'.$request->path);
        // }
        $section->update($request->all());
        return redirect()->route('section.show',$section->id)->withSuccess('Saved');

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



    public function changeStatus(Request $request)
    {

        $section = Section::find($request->id);

        if($section->status){
            $section->status = 0;
            $section->save();
            return response()->json(['type' => 'danger', 'message' => 'CLOSED: '.$section->name.'']);
        }
        else{
            $section->status = 1;
            $section->save();
            return response()->json(['type' => 'success', 'message' => 'OPENED: '.$section->name.'']);
        }

    }



    public function folder($id)
    {

        $section = Section::find($id);
        $directory = public_path()."\\storage"."\\".$section->path;

        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && !(file_exists($directory))) {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return response()->json(['message' => $msg, 'type' => 'danger']);
        }

        $explorer =  'c:\\windows\\explorer.exe';
        shell_exec("$explorer /n,/e,$directory");

        return response()->json(['message' => 'Folder opened', 'type' => 'success']);

    }



    public function checkActivity($student, $activity)
    {

        $record = Record::where(['student_id' => $student->id, 'activity_id' => $activity->id])->get()->first();
        if(count($record) != 0){
            $string = "<a href='".route('post.show',$activity->Post->id)."'><span class='green'><i class='fa fa-check' style='font-size:14pt'></i></span></a><br>";
            if($record->date == $activity->date)
                $string = $string."<small class='green'>".$record->date."</small>";
            else
                $string = $string."<small class='orange'>".$record->date."</small>";
            return $string;
        }

        return "<a href='".route('post.show',$activity->Post->id)."'><span class='red'><i class='fa fa-close' style='font-size:14pt'></i></span></a>";
    }

    public function getActivityStats($student, $activity)
    {
        $record = Record::where(['student_id' => $student->id, 'activity_id' => $activity->id])->get()->first();
        if(count($record) != 0)
            return true;

        return false;
    }

    public function getActivityDateSubmitted($student, $activity)
    {
        $record = Record::where(['student_id' => $student->id, 'activity_id' => $activity->id])->get()->first();
        return $record->date;
    }

}
