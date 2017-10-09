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
        $path = ''.$lname.', '.$fname.'';
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

        $section_path = '/storage'.'/'.$sect->path;
        if (!File::exists(public_path().'/'.$section_path.'/'.$path))
        {
            File::makeDirectory(public_path().'/'.$section_path.'/'.$path,0777,true);
            File::makeDirectory(public_path().'/'.$section_path.'/'.$path.'/files',0777,true);
            File::makeDirectory(public_path().'/'.$section_path.'/'.$path.'/trash',0777,true);
        }

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
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\";
        $contents = File::allFiles($directory);
        if($contents != null)
            foreach ($contents as $key => $file) {
               $path = pathinfo((string)$file."");
               $files[$key] = (object) array('name' => $path['basename'], 'type' => $path['extension'], 'path' => $path['dirname']);
           }
       else
           $files = null;

        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.student.show')->with('student', $student)->with('files', $files);
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
        if($student->section != $request->section){
            $section1 = Section::find($student->section);
            $newSection = Section::find($request->section);
            File::move(public_path()."\\storage\\".$section1->path.'\\'.$student->path, public_path().'\\storage\\'.$newSection->path.'\\'.$student->path);
        }

        // Rename the student folder if student name is changed
        if(($student->fname != $request->fname)||($student->lname != $request->lname)){
            $section1 = Section::find($request->section);
            $newPath = ''.ucwords(strtolower($request->lname)).', '.ucwords(strtolower($request->fname)).'';
            $oldPath = $student->path;
            File::move(public_path()."\\storage\\".$section1->path.'\\'.$oldPath, public_path().'\\storage\\'.$section1->path.'\\'.$newPath);
            $student->path = $newPath;
        }

        $student->lname = ucwords(strtolower($request->lname));
        $student->fname = ucwords(strtolower($request->fname));
        $student->save($request->all());
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
                $path = ''.$lname.', '.$fname.'';
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
                $path = ''.$lname.', '.$fname.'';
                $section = strtoupper($column->section);
                $section_path = null;
                foreach ($sect as $key1 => $s) {
                    if($s->name == $section)
                        $section_path = $s->path;
                }
                $section_path = '/storage'.'/'.$section_path;
                if (!File::exists(public_path().'/'.$section_path.'/'.$path))
                {
                    File::makeDirectory(public_path().'/'.$section_path.'/'.$path,0777,true);
                    File::makeDirectory(public_path().'/'.$section_path.'/'.$path.'/files',0777,true);
                    File::makeDirectory(public_path().'/'.$section_path.'/'.$path.'/trash',0777,true);
                }
            }
            return redirect()->route('student.index')->withSuccess('Successfully Added Students.');
        }else{
            return redirect()->back()->withError('No file');
        }
    }


}
