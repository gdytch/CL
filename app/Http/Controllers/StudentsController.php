<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Image;
use Excel;
use Auth;
use App\Student;
use App\Section;
use App\Record;
use App\Exam;
use App\Exam_Entry;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table_list = array();
        if ($request->id == 'all' || $request->id == null) {
            $students = Student::all();
        } else {
            $students = Student::where('section', $request->id)->orderBy('gender', 'desc')->get();
        }

        $sections = Section::all();

        foreach ($students as $student) {
            $table_list[] = (object) array(
                'id'           => $student->id,
                'fname'        => $student->fname,
                'lname'        => $student->lname,
                'section_name' => $student->sectionTo->name,
                'section_id'   => $student->section,
                'gender'       => $student->gender,
            );
        }

        $variables = array(
             'dashboard_content' => 'dashboards.admin.student.index',
             'sections'          => $sections,
             'table_list'        => $table_list,
        );

        return view('layouts.admin')->with($variables);
    }

    public function showThumbnail(Request $request)
    {
        $table_list = array();
        if ($request->id == 'all' || $request->id == null) {
            $students = Student::all();
        } else {
            $students = Student::where('section', $request->id)->get();
        }

        $sections = Section::all();

        foreach ($students as $student) {
            $table_list[] = (object) array(
                'id'           => $student->id,
                'fname'        => $student->fname,
                'lname'        => $student->lname,
                'section_name' => $student->sectionTo->name,
                'section_id'   => $student->section,
                'avatar'       => $student->avatar
            );
        }

        $variables = array(
             'dashboard_content' => 'dashboards.admin.student.index-thumbnail',
             'sections'          => $sections,
             'table_list'        => $table_list,
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

        $validator = Validator::make($request->all(), [
            'avatar_file' => 'file|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->route('student.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $lname = ucwords(strtolower($request->lname));
        $fname = ucwords(strtolower($request->fname));
        if (count(Student::where(['lname' => $lname, 'fname' => $fname])->get()) != 0) {
            return redirect()->back()->withErrors('Student already exists');
        }

        $path     = ''.$lname.' '.$fname.'';
        $password = $request->password;
        $section  = $request->section;

        $student = new Student();
        $student->lname    = $lname;
        $student->fname    = $fname;
        $student->path     = $path;
        $student->password = $password;
        $student->section  = $section;
        $student->gender   = $request->gender;
        $student->theme    = 'green';

        if ($request->hasFile('avatar_file')) {
            $avatar = $request->file('avatar_file');
            $filename = $student->lname."-".$student->fname." - ".time().".".$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(250, 250)->save(public_path().'/storage/avatar/'.$filename);
            $avatar= $filename;
        } else {
            $avatar = 'default-avatar.png';
        }

        $student->avatar = $avatar;
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
        if ($student->section == null) {
            return redirect()->route('student.edit', $student->id)->withError("Student has no section");
        }

        $table_item = $this->checkActivities($student);
        $exam_results = $this->studentExamPaper($student);
        $files = $this->getFiles($student);
        $sections = Section::all();
        $variables = array(
           'dashboard_content' => 'dashboards.admin.student.show',
           'student'           => $student,
           'table_item'        => $table_item,
           'sections'          => $sections,
           'exam_results'      => $exam_results,
           'files'             => $files
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
            'student'           => $student,
            'sections'          => $sections
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
        $validator = \Validator::make($request->all(), [
            'avatar_file' => 'file|max:10000',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $student = Student::find($id);
        // Move the student folder if student is moved to a diff section
        if ($student->section != null) {
            if ($student->section != $request->section) {
                $section1 = Section::find($student->section);
                $newSection = Section::find($request->section);
                if(!Storage::exists($section1->path.'/'.$student->path, $newSection->path.'/'.$student->path))
                    Storage::move($section1->path.'/'.$student->path, $newSection->path.'/'.$student->path);
            }
        } else {
            $newSection = Section::find($request->section);
            $folder_path = '/'.$newSection->path.'/'.$student->path;
            $this->makeFolder($path);
        }

        // Rename the student folder if student name is changed
        if (($student->fname != $request->fname)||($student->lname != $request->lname)) {
            $section1 = Section::find($request->section);
            $newPath = ''.ucwords(strtolower($request->lname)).' '.ucwords(strtolower($request->fname)).'';
            $oldPath = $student->path;
            Storage::move($section1->path.'/'.$oldPath, $section1->path.'/'.$newPath);
            $student->path = $newPath;
        }

        //new avatar
        if ($request->hasFile('avatar_file')) {
            $avatar = $request->file('avatar_file');
            $filename = $student->lname."-".$student->fname." - ".time().".".$avatar->getClientOriginalExtension();
            if ($student->avatar != 'default-avatar.png') {
                Storage::delete("avatar/".$student->avatar);
            }
            Image::make($avatar)->fit(250)->save(public_path().'/storage/avatar/'.$filename);
            $student->avatar = $filename;
        }

        $student->update($request->all());
        $student->save();
        //
        return response()->json(['student' => $student, 'sectionName' => $student->sectionTo->name, 'avatar_file' => asset('storage/avatar/'.$student->avatar)]);
    }



    public function update_password(Request $request, $id)
    {

        $this->Validate($request, [
            'password' => 'confirmed|min:5'
        ]);

        $student = Student::find($id);
        $student->password = $request->password;
        $student->save();

        return response()->json(['success' => 'Password updated.']);
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
        if ($student->avatar != 'default-avatar.png' && Storage::exists('/avatar/'.$student->avatar)) {
            Storage::delete('avatar/'.$student->avatar);
        }
        Storage::deleteDirectory($section_path.'/'.$student->path);

        return redirect()->route('student.index')->withSuccess('Account Deleted');
    }



    public function batch(Request $request)
    {

        if (!$request->hasFile('file')) {
            return redirect()->back()->withError('No file');
        }

        $file = $request->file('file');

        $results = Excel::load($file, function ($reader) {
        })->get();

        $students = array();
        $password = bcrypt('123456');
        $sect = Section::all();
        // Fetch data from Excel file
        foreach ($results as $key => $column) {
            if ($column->fname == null) {
                $column->fname = 'fname';
            }
            $lname = ucwords(strtolower($column->lname));
            $fname = ucwords(strtolower($column->fname));
            $section = strtoupper($column->section);
            $path = ''.$lname.' '.$fname.'';
            $sectionid = null;
            foreach ($sect as $key1 => $s) {
                if ($s->name == $section) {
                    $sectionid = $s->id;
                }
            }

            $students[$key] = [
                'lname'    => $lname,
                'fname'    => $fname,
                'path'     => $path,
                'avatar'   => 'default-avatar.png',
                'password' => $password,
                'section'  => $sectionid,
                'theme'    => 'green'
            ];
        }

        // Save to database
        Student::insert($students);

        // Create folders for students
        foreach ($results as $key => $column) {
            $section_path = null;
            if ($column->fname == null) {
                $column->fname = 'fname';
            }
            $lname = ucwords(strtolower($column->lname));
            $fname = ucwords(strtolower($column->fname));
            $section = strtoupper($column->section);
            $path = ''.$lname.' '.$fname.'';
            foreach ($sect as $key1 => $s) {
                if ($s->name == $section) {
                    $section_path = $s->path;
                }
            }
            if ($section_path == null) {
                continue;
            }
            $folder_path = '/'.$section_path.'/'.$path;
            $this->makeFolder($folder_path);
        }

        return redirect()->route('student.index')->withSuccess('Successfully Added Students.');
    }



    public function folder($id)
    {

        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\files";
        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && !(file_exists($directory))) {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return response()->json(['message' => $msg, 'type' => 'danger']);

        }

        $explorer =  'c:\\windows\\explorer.exe';
        shell_exec("$explorer \\n,\\e,$directory");

        return response()->json(['message' => 'Folder opened: '.$student->lname.', '.$student->fname, 'type' => 'success']);
    }


    public function examFolder($id)
    {

        $student = Student::find($id);
        $directory = public_path()."\\storage"."\\".$student->sectionTo->path."\\".$student->path."\\exam_files";
        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && !(file_exists($directory))) {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return redirect()->back()->withErrors($msg);
        }

        $explorer =  'c:\\windows\\explorer.exe';
        shell_exec("$explorer \\n,\\e,$directory");

        return redirect()->back();
    }


    public function makeFolder($path)
    {

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0777, true);
            Storage::makeDirectory($path.'/files', 0777, true);
            Storage::makeDirectory($path.'/trash', 0777, true);
        }
    }



    public function checkActivities($student)
    {

        $table_item = null;

        if (count($student->Sectionto->Activities) > 0) {
            foreach ($student->Sectionto->Activities()->orderBy('created_at', 'desc')->where('active', true)->get() as $activity) {
                $files = null;
                if (count($student->RecordsOf($activity->id))>0) {
                    $submitted = true;
                    foreach ($student->RecordsOf($activity->id) as $result) {
                        $files[] = (object) array('filename' => $result->filename,  'date_submitted' => date("M d Y", strtotime($result->created_at)));
                    }
                } else {
                    $submitted = false;
                }

                $table_item[] = (object) array(
                    'name'        => $activity->name,
                    'date'        => date("M d Y", strtotime($activity->date)),
                    'description' => $activity->description,
                    'submitted'   => $submitted,
                    'files'       => $files,
                    'id'        => $activity->id

                );
            }
        }

        return $table_item;
    }



    public function getFiles($student)
    {

        // Get student's files

        $directory = "/".$student->sectionTo->path."/".$student->path."/files";

        $this->verifyFileRecords($student);

        if (Storage::exists($directory)) {
            $contents = Storage::allFiles($directory);
        } else {
            $folder_path = '/'.$student->sectionTo->path.'/'.$student->path;
            $this->makeFolder($folder_path);
            $error = array("Student folder wasn't found.", 'Generated a folder for student');
            $contents = null;
        }

        if ($contents == null) {
            return null;
        }

        foreach ($contents as $key => $file1) {
            $file = pathinfo((string)$file1."");
            $temp = explode("id=", $file['filename']);
            $file_id = $temp[1];
            $file['filename'] = $temp[0];
            $files[$key] = (object) array('name' => $file['filename'], 'type' => $file['extension'], 'path' => $file['dirname'], 'id' => $file_id, 'basename' => $file['basename']);
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

    // Verify if File Records exists in physical storage
    public function verifyFileRecords($student)
    {

        $records = Record::where(['student_id' => $student->id, 'active' => true])->get();

        if (count($records) != 0) {
            foreach ($records as $record) {
                if (!Storage::exists($student->sectionTo->path."/".$student->path."/files/".$record->basename)) {
                    $this_record = Record::find($record->id);
                    $this_record->delete();
                }
            }
        }
    }


    public function studentExamPaper($student)
    {
        $exam_entries = Exam_Entry::where(['student_id' => $student->id, 'active' => false])->get();
        if(count($exam_entries) == 0)
            return null;
        $exam_results = null;
        foreach ($exam_entries as $key => $exam_entry) {
            $exam = Exam::find($exam_entry->exam_id);
            $exam_paper = $exam->ExamPaper;
            $exam_paper['date'] = $exam_entry->date;
            $exam_paper['score'] = $exam_entry->score;
            $exam_paper['exam_id'] = $exam->id;
            $exam_paper['submitted'] = $exam_entry->active;
            $exam_paper['show_to_students'] = $exam->show_to_students;
            $exam_results[$key] = $exam_paper;

        }

        return $exam_results;
    }


}
