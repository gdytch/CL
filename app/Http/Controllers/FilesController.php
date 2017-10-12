<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Student;
use App\Activity;
use App\Record;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->Validate($request, [
            'file' => 'max:30000',
        ]);
        $student = Student::find($request->id);
        $activity = Activity::find($request->activity);
        $directory = "\\public"."\\".$student->sectionTo->path."\\".$student->path."\\files\\";
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $file = $activity->name." - ".$student->lname.".".$extension;

        //if filename already exist add numbers at the end of the filename
        if(File::exists(public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$file)){
            $x = 2;
            while (File::exists(public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$activity->name." - ".$student->lname." (".$x.").".$extension)) {
                $x++;
            }
            $request->file('file')->storeAs($directory, $activity->name." - ".$student->lname." (".$x.").".$extension);
        }else{
            $request->file('file')->storeAs($directory, $activity->name." - ".$student->lname.".".$extension);
        }

        $this->recordFile($activity->id, $student->id, $file);

        return redirect()->route('home')->withSuccess('File Submitted');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\";
        $file = $request->file;
        return response()->download($directory."".$file);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $student = Student::find($id);
        switch ($request->method) {
            case 'recycle':
                $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$request->file;
                $trash = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\trash\\".$request->file;
                File::move($directory, $trash);
                return redirect()->route('home')->withSuccess('File moved to trash');
                break;

            case 'restore':
                $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$request->file;
                $trash = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\trash\\".$request->file;
                File::move($trash, $directory);
                return redirect()->route('trash')->withSuccess('File restored');
                break;

            case 'empty':
                $trash = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\trash\\";
                File::cleanDirectory($trash);
                return redirect()->route('trash')->withSuccess('All files deleted');
                break;

                //delete
            default:
                $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\trash\\".$request->file;
                File::delete($directory);
                return redirect()->route('trash')->withSuccess('File deleted');
                break;
        }

    }

    public function recordFile($activity_id, $student_id, $file)
    {
        $record = new Record();
        $record->student_id = $student_id;
        $record->activity_id = $activity_id;
        $record->filename = $file;
        $record->save();
    }

    public function deleteRecord()
    {

    }

}
