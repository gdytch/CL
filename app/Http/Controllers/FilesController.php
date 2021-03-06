<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Student;
use App\Activity;
use App\Record;
use Image;

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
            'file'     => 'max:30000',
            'activity' => 'required'
        ]);
        $student   = Student::find($request->id);
        $activity  = Activity::find($request->activity);
        $directory = '/'.$student->sectionTo->path."/".$student->path."/files";
        $file      = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        //check if file uploaded follows the filetype rule
        if(!$this->checkFileType($activity, $extension))
        {
            $errors[] = 'Invalid filetype';
            $errors[] = 'Allowed files for <b>'. $activity->name .'</b>: '.$activity->FTRule->extensions;
            return response()->json(['errors' => $errors]);
        }

        $filename = $this->getFilename($student, $activity, $file);
        $basename = $this->recordFile($activity->id, $student->id, $filename, $extension);

        if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' ){
            $img = Image::make($request->file('file'));
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save(public_path().'/storage'.$directory.'/'.$basename);
        }
        else
            $request->file('file')->storeAs($directory, $basename);

        $file = Record::where(['basename' => $basename])->get()->first();

        if(file_exists(public_path('img/icons/'.$extension.'.png'))){
            $file_icon = "". asset('img/icons/'.$extension.'.png');
        }else{
            $file_icon = asset('img/icons/file.png');
        }


        return response()->json([
            'activityId'    => $activity->id,
            'filename'      => $file->filename,
            'basename'      => $basename,
            'studentId'     => $student->id,
            'fileId'        => $file->id,
            'extension'     => $extension,
            'fileIcon'      => $file_icon,
            'image_src'     => asset('storage/'.$student->sectionTo->path."/".$student->path."/files".'/'.$file->basename),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $student   = Student::find($id);
        $file      = $request->file;
        $directory = public_path("\\storage\\".$student->sectionTo->path."\\".$student->path."\\files\\".$file);

        return response()->download($directory);

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
        $trash     = "/".$student->sectionTo->path."/".$student->path."/trash/".$request->file;

        switch ($request->method)
        {
            case 'recycle':
                if(Storage::exists($trash))
                    Storage::delete($trash);
                Storage::move($directory, $trash);
                if($record = Record::find($request->file_id)){
                    $record->active = false;
                    $record->update();
                }
                $activity = Activity::find($record->activity_id);
                $post = $activity->Post;
                return response()->json(['activityId' => $record->activity_id, 'post' => $post, 'fileId' => $record->id, 'activity' => $activity]);

                break;

            case 'restore':
                if(Storage::exists($directory))
                    Storage::delete($directory);
                Storage::move($trash, $directory);
                if($record = Record::find($request->file_id)){
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
                if($record = Record::find($request->file_id))
                    $record->delete();
                return redirect()->route('trash')->withSuccess('File deleted');
                break;
        }

    }



    public function recordFile($activity_id, $student_id, $filename, $extension)
    {

        $record = new Record();
        $record->student_id = $student_id;
        $record->activity_id = $activity_id;
        $record->filename = $filename.".".$extension;
        $record->date = date("Y-m-d", time());
        $record->save();

        $record->basename = $filename." id=". $record->id .".".$extension;
        $record->update();
        return $record->basename;

    }



    public function checkFileType($activity, $extension)
    {

        $extension = strtolower($extension);
        $rule_extensions = str_replace(' ', '', $activity->FTRule->extensions);
        $rule_extensions = str_replace('.', '', $rule_extensions);
        if($rule_extensions == 'any' || $activity->FTRule->extensions == null || $activity->FTRule->name == 'Default')
            return true;

        $rule_extensions = explode(',', $rule_extensions);
        foreach ($rule_extensions as $key => $rule) {
            $rule_extensions[$key] = strtolower($rule);
        }

        if(!in_array($extension, $rule_extensions))
            return false;

        return true;

    }



    public function getFilename($student, $activity, $file)
    {

        $extension = $file->getClientOriginalExtension();
        $filename = $activity->name." - ".$student->lname;
        $x = 0;
        while(count(Record::where(['filename' => $filename, 'student_id' => $student->id])->get()) != 0)
        {
            $x++;
            $filename = $activity->name." - ".$student->lname." (".$x.")";
        }

        return $filename;

    }


}
