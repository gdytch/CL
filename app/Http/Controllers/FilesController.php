<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
            'activity' => 'required'
        ]);



        $student = Student::find($request->id);
        $activity = Activity::find($request->activity);


        $directory = '/'.$student->sectionTo->path."/".$student->path."/files";
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $file = $activity->name." - ".$student->lname.".".$extension;

        //check if file uploaded follows the filetype rule
        if(!$this->checkFileType($activity, $extension))
        {
            $errors[] = 'Invalid filetype';
            $errors[] = 'Allowed files: '.$activity->FTRule->extensions;
            return redirect()->back()->withErrors($errors);
        }


        //if filename already exist add numbers at the end of the filename
        if(Storage::exists("/".$student->sectionTo->path."/".$student->path."/files/".$file)){
            $x = 2;
            while (Storage::exists("/".$student->sectionTo->path."/".$student->path."/files/".$activity->name." - ".$student->lname." (".$x.").".$extension))
                $x++;

            $file = $activity->name." - ".$student->lname." (".$x.").".$extension;
        }
        $request->file('file')->storeAs($directory, $file);

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
        $file = $request->file;
        $directory = public_path("/storage/".$student->sectionTo->path."/".$student->path."/files/".$file);
        // $directory = Storage::disk('public')->url($student->sectionTo->path."/".$student->path."/files/".$file);

        return response()->download($directory);
        // return Storage::getDriver()->getAdapter()->applyPathPrefix($file);
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

        $directory = "/".$student->sectionTo->path."/".$student->path."/files/".$request->file;
        $trash = "/".$student->sectionTo->path."/".$student->path."/trash/".$request->file;

        switch ($request->method)
        {
            case 'recycle':
                if(Storage::exists($trash))
                    Storage::delete($trash);
                Storage::move($directory, $trash);
                if($record = Record::where(['filename' => $request->file, 'active' => true])->get()->first()){
                    $record->active = false;
                    $record->update();
                }
                return redirect()->route('home')->withSuccess('File moved to trash');

                break;

            case 'restore':
                if(Storage::exists($directory))
                    Storage::delete($directory);
                Storage::move($trash, $directory);
                if($record = Record::where(['filename' => $request->file, 'active' => false])->get()->last()){
                    $record->active = true;
                    $record->update();
                }
                return redirect()->route('trash')->withSuccess('File restored');
                break;

            case 'empty':
                $trash = "/".$student->sectionTo->path."/".$student->path."/trash";
                Storage::deleteDirectory($trash);
                Storage::makeDirectory($trash);
                if($record = Record::where(['student_id' => $student->id, 'active' => false])){
                    $record->delete();
                }
                return redirect()->route('trash')->withSuccess('All files deleted');
                break;

                //delete
            default:

                Storage::delete($trash);
                $record = Record::where(['filename' => $request->file, 'active' => false]);
                $record->delete();
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
        $record->date = date("Y-m-d", time());
        $record->save();

    }



    public function checkFileType($activity, $extension)
    {

        $rule_extensions = str_replace(' ', '', $activity->FTRule->extensions);

        if($rule_extensions == 'any' || $activity->FTRule->extensions == null || $activity->FTRule->extensions == 'all')
            return true;
            
        $rule_extensions = explode(',', $rule_extensions);

        if(!in_array($extension, $rule_extensions))
            return false;

        return true;

    }

}
