<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Excel;
use Auth;
use App\Student;
use App\Section;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->id == 'all' || $request->id == null)
            $students = Student::all();
        else {
            $students = Student::where('section', $request->id)->get();
        }

        $sections = Section::all();
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.student.index')->with('students', $students)->with('sections', $sections);
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
        $lname = ucwords(strtolower($request->lname));
        $fname = ucwords(strtolower($request->fname));
        $path = ''.$lname.' '.$fname.'';
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

        $sect = Section::find($section);

        $folder_path = '/storage'.'/'.$sect->path.'/'.$path;
        $this->makeFolder($folder_path);

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
        $contents = null;
        $student = Student::find($id);
        $error = null;

        //check if student has a section
        if($student->section == null){
            return redirect()->route('student.edit',$student->id)->withError("Student has no section");
        }

        $files = $this->getFiles($student);

        $file_log = $this->checkActivities($student);

        $variables = array(
           'dashboard_content' => 'dashboards.admin.student.show',
           'student' => $student,
           'files' => $files,
           'file_log' => $file_log,
        );

        return view('layouts.admin')->with($variables)->withErrors($error);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        $sections = Section::all();
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.student.edit')->with('student', $student)->with('sections', $sections);
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


        $student = Student::find($id);
        // Move the student folder if student is moved to a diff section
        if($student->section != null){
            if($student->section != $request->section){
                $section1 = Section::find($student->section);
                $newSection = Section::find($request->section);
                    File::move(public_path()."\\storage\\".$section1->path.'\\'.$student->path, public_path().'\\storage\\'.$newSection->path.'\\'.$student->path);
            }
        }
        else{
            $newSection = Section::find($request->section);
            $folder_path = '/storage'.'/'.$newSection->path.'/'.$student->path;
            $this->makeFolder($path);
        }

        // Rename the student folder if student name is changed
        if(($student->fname != $request->fname)||($student->lname != $request->lname)){
            $section1 = Section::find($request->section);
            $newPath = ''.ucwords(strtolower($request->lname)).' '.ucwords(strtolower($request->fname)).'';
            $oldPath = $student->path;
            File::move(public_path()."\\storage\\".$section1->path.'\\'.$oldPath, public_path().'\\storage\\'.$section1->path.'\\'.$newPath);
            $student->path = $newPath;
        }

        $student->lname = ucwords(strtolower($request->lname));
        $student->fname = ucwords(strtolower($request->fname));
        $student->update($request->all());
        $student->save();

        return redirect()->route('student.show',$id)->withSuccess('Saved');
    }

    public function update_password(Request $request, $id){
        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);

        $student = Student::find($id);
        if(Hash::check($request->old_password, $student->password)){
            $student->password = $request->password;
            $student->save();

        }else {
            return redirect()->back()->withError('Incorrect password');
        }
        Auth::logout();
        return redirect('checkUsers?id='.$student->id)->withSuccess('Enter new password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        $section = Section::find($student->section);
        $section_path = '/storage'.'/'.$section->path;
        File::deleteDirectory(public_path().'/'.$section_path.'/'.$student->path);
        return redirect()->route('student.index')->withSuccess('Account Deleted');
    }

    public function batch(Request $request){
        if($request->hasFile('file')){
            $file = $request->file('file');

            $results = Excel::load($file, function($reader) {})->get();

            $students = array();
            $password = bcrypt('123456');
            $avatar = 'default-avatar.png';
            $sect = Section::all();
            // Fetch data from Excel file
            foreach ($results as $key => $column) {
                if($column->fname == null)
                    $column->fname = 'fname';
                $lname = ucwords(strtolower($column->lname));
                $fname = ucwords(strtolower($column->fname));
                $section = strtoupper($column->section);
                $path = ''.$lname.' '.$fname.'';
                $sectionid = null;
                foreach ($sect as $key1 => $s) {
                    if($s->name == $section)
                        $sectionid = $s->id;
                }
                $students[$key] = ['lname' => $lname, 'fname' => $fname, 'path' => $path, 'avatar' => $avatar, 'password' => $password, 'section' => $sectionid];
            }

            // Save to database
            Student::insert($students);

            // Create folders for students
            foreach ($results as $key => $column) {
                $lname = ucwords(strtolower($column->lname));
                $fname = ucwords(strtolower($column->fname));
                $path = ''.$lname.' '.$fname.'';
                $section = strtoupper($column->section);
                $section_path = null;
                foreach ($sect as $key1 => $s) {
                    if($s->name == $section)
                        $section_path = $s->path;
                }
                if($section_path == null)
                    continue;
                $section_path = '/storage'.'/'.$section_path.'/'.$path;
                $this->makeFolder($folder_path);
            }
            return redirect()->route('student.index')->withSuccess('Successfully Added Students.');
        }else{
            return redirect()->back()->withError('No file');
        }
    }

    public function folder($id)
    {
        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\";
        if ((strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && (file_exists($directory))) {
            $explorer =  'c:\\windows\\explorer.exe';
            shell_exec("$explorer /n,/e,$directory");
            return redirect()->back();
        } else {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return redirect()->back()->withErrors($msg);
        }
    }

    public function makeFolder($path)
    {
        if (!File::exists(public_path().'/'.$path))
        {
            File::makeDirectory(public_path().'/'.$path,0777,true);
            File::makeDirectory(public_path().'/'.$path.'/files',0777,true);
            File::makeDirectory(public_path().'/'.$path.'/trash',0777,true);
        }
    }

    public function checkActivities($student)
    {
        $file_log = null;
        //Check files Submitted
        $activities = $student->sectionTo->Activities;
        foreach ($activities as $key => $activity) {
           $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files\\".$activity->name."*";
           $result = File::glob($directory);
           if($result)
           $file_log[] = (object) array('activity' => $activity->name, 'status' => true, 'path' => $directory);
           else
           $file_log[] = (object) array('activity' => $activity->name, 'status' => false, 'path' => $directory);
        }
        return $file_log;
    }

    public function getFiles($student)
    {
        $files = null;
        // Get student's files
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files";
        if(File::exists($directory)){
            $contents = File::allFiles($directory);
        }else {
            $folder_path = '/storage'.'/'.$student->sectionTo->path.'/'.$student->path;
            $this->makeFolder($folder_path);
            $error = array("Student folder wasn't found.", 'Generated a folder for student');
        }

        if($contents != null)
            foreach ($contents as $key => $file) {
               $path = pathinfo((string)$file."");
               $files[$key] = (object) array('name' => $path['filename'], 'type' => $path['extension'], 'path' => $path['dirname']);
        }

        return $files;
    }


}
