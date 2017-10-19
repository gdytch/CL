<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        else
            $students = Student::where('section', $request->id)->get();

        $sections = Section::all();

        $variables = array(
             'dashboard_content' => 'dashboards.admin.student.index',
             'students' => $students,
             'sections' => $sections
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

        $sections = Section::all();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.student.create',
            'sections' => $sections
        );

        return view('layouts.admin')->with($variables);

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
        $student->theme = 'green';
        $student->save();

        $sect = Section::find($section);

        $folder_path = '/'.$sect->path.'/'.$path;
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

        $student = Student::find($id);

        //check if student has a section
        if($student->section == null)
            return redirect()->route('student.edit',$student->id)->withError("Student has no section");

        $table_item = $this->checkActivities($student);

        $variables = array(
           'dashboard_content' => 'dashboards.admin.student.show',
           'student' => $student,
           'table_item' => $table_item,
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

        $student = Student::find($id);
        $sections = Section::all();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.student.edit',
            'student' => $student,
            'sections' => $sections
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

        $student = Student::find($id);
        // Move the student folder if student is moved to a diff section
        if($student->section != null){
            if($student->section != $request->section)
            {
                $section1 = Section::find($student->section);
                $newSection = Section::find($request->section);
                Storage::move($section1->path.'/'.$student->path, $newSection->path.'/'.$student->path);
            }
        }
        else
        {
            $newSection = Section::find($request->section);
            $folder_path = '/'.$newSection->path.'/'.$student->path;
            $this->makeFolder($path);
        }

        // Rename the student folder if student name is changed
        if(($student->fname != $request->fname)||($student->lname != $request->lname))
        {
            $section1 = Section::find($request->section);
            $newPath = ''.ucwords(strtolower($request->lname)).' '.ucwords(strtolower($request->fname)).'';
            $oldPath = $student->path;
            Storage::move($section1->path.'/'.$oldPath, $section1->path.'/'.$newPath);
            $student->path = $newPath;
        }

        $student->lname = ucwords(strtolower($request->lname));
        $student->fname = ucwords(strtolower($request->fname));
        $student->update($request->all());
        $student->save();

        return redirect()->route('student.show',$id)->withSuccess('Saved');

    }



    public function update_password(Request $request, $id)
    {

        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);

        $student = Student::find($id);

        if(!Hash::check($request->old_password, $student->password))
            return redirect()->back()->withError('Incorrect password');

        $student->password = $request->password;
        $student->save();

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
        $section_path ='/'.$section->path;
        Storage::deleteDirectory($section_path.'/'.$student->path);

        return redirect()->route('student.index')->withSuccess('Account Deleted');

    }



    public function batch(Request $request)
    {

        if(!$request->hasFile('file'))
            return redirect()->back()->withError('No file');

        $file = $request->file('file');

        $results = Excel::load($file, function($reader) {})->get();

        $students = array();
        $password = bcrypt('123456');
        $sect = Section::all();
        // Fetch data from Excel file
        foreach ($results as $key => $column)
        {
            if($column->fname == null)
                $column->fname = 'fname';
            $lname = ucwords(strtolower($column->lname));
            $fname = ucwords(strtolower($column->fname));
            $section = strtoupper($column->section);
            $path = ''.$lname.' '.$fname.'';
            $sectionid = null;
            foreach ($sect as $key1 => $s)
                if($s->name == $section)
                    $sectionid = $s->id;

            $students[$key] = ['lname' => $lname, 'fname' => $fname, 'path' => $path, 'avatar' => 'default-avatar.png', 'password' => $password, 'section' => $sectionid, 'theme' => 'green'];
        }

        // Save to database
        Student::insert($students);

        // Create folders for students
        foreach ($results as $key => $column)
        {
            $section_path = null;
            if($column->fname == null)
                $column->fname = 'fname';
            $lname = ucwords(strtolower($column->lname));
            $fname = ucwords(strtolower($column->fname));
            $section = strtoupper($column->section);
            $path = ''.$lname.' '.$fname.'';
            foreach ($sect as $key1 => $s)
            {
                if($s->name == $section)
                    $section_path = $s->path;
            }
            if($section_path == null)
                continue;
            $folder_path = '/'.$section_path.'/'.$path;
            $this->makeFolder($folder_path);
        }

        return redirect()->route('student.index')->withSuccess('Successfully Added Students.');

    }



    public function folder($id)
    {

        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files";
        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && !(file_exists($directory)))
        {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return redirect()->back()->withErrors($msg);
        }

        $explorer =  'c:\\windows\\explorer.exe';
        shell_exec("$explorer \\n,\\e,$directory");

        return redirect()->back();
    }



    public function makeFolder($path)
    {

        if (!Storage::exists($path))
        {
            Storage::makeDirectory($path,0777,true);
            Storage::makeDirectory($path.'/files',0777,true);
            Storage::makeDirectory($path.'/trash',0777,true);
        }

    }



    public function checkActivities($student)
    {

        $table_item = null;

        if(count($student->Sectionto->Activities) > 0)
            foreach ($student->Sectionto->Activities()->orderBy('name', 'desc')->where('active', true)->get() as $activity)
            {
                $files = null;
                if(count($student->RecordsOf($activity->id))>0)
                {
                    $submitted = true;
                    foreach ($student->RecordsOf($activity->id) as $result)
                        $files[] = (object) array('filename' => $result->filename,  'date_submitted' => date("M d Y", strtotime($result->created_at)));
                }
                else
                    $submitted = false;

                $table_item[] = (object) array(
                    'name' => $activity->name,
                    'date' => date("M d Y", strtotime($activity->date)),
                    'description' => $activity->description,
                    'submitted' => $submitted,
                    'files' => $files,
                );
            }

        return $table_item;

    }



    public function getFiles($student)
    {

        $files = null;
        $contents = null;
        // Get student's files

        $directory = "/".$student->sectionTo->path."/".$student->path."/files";
        if(Storage::exists($directory))
            $contents = Storage::allFiles($directory);
        else
        {
            $folder_path = '/'.$student->sectionTo->path.'/'.$student->path;
            $this->makeFolder($folder_path);
            $error = array("Student folder wasn't found.", 'Generated a folder for student');
        }

        if($contents != null)
            foreach ($contents as $key => $file)
            {
               $path = pathinfo((string)$file."");
               $files[$key] = (object) array('name' => $path['filename'], 'type' => $path['extension'], 'path' => $path['dirname']);
            }

        return $files;

    }



    public function theme(Request $request)
    {

        $student = Student::find(Auth::user()->id);
        $student->theme = $request->get('theme');
        $student->save();

        return redirect()->back();

    }


}
