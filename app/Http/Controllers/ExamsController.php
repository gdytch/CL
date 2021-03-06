<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Student;
use App\Exam;
use App\Exam_Paper;
use App\Exam_Test;
use App\Exam_Item;
use App\Exam_Item_Choice;
use App\Exam_Entry;
use App\Exam_Answer;


class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $exam_papers = Exam_Paper::all();

        $exams = Exam::all()->sortBy('section_id');
        $submitted = 0;
        foreach ($exams as $key => $exam) {
            $submitted = 0;
            foreach ($exam->SectionTo->Students as $key2 => $student) {
                $entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
                if($entry != null)
                    if($entry->active == false)
                        $submitted++;
            }
            $exams[$key]['submitted'] = $submitted;
        }

        foreach ($sections as $key => $section) {
            $temp = null;
            foreach ($exams as $key => $exam) {
                if($exam->section_id == $section->id){
                    $temp[] = $exam;
                }
            }
            $section_exams[$section->id] = $temp;
        }

        $variables = array(
            'dashboard_content' => 'dashboards.admin.exam.index',
            'sections'          => $sections,
            'exam_papers'       => $exam_papers,
            'exams'             => $exams,
            'section_exams'     => $section_exams

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
        $exam = new Exam($request->all());
        $exam->save();

        return redirect()->back()->withSuccess('Exam Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam = Exam::find($id);
        if(!$exam->generated_papers)
            return redirect()->back()->withError('Generate Papers first');
        $exam_paper = $exam->ExamPaper;
        $students = Student::where('section', $exam->SectionTo->id)->orderBy('gender', 'desc')->orderBy('lname', 'asc')->get();
        $section = $exam->SectionTo;
        $students = $this->examResult($exam, $students);
        $variables = array(
            'dashboard_content' => 'dashboards.admin.exam.show',
            'exam_paper'        => $exam_paper,
            'students'          => $students,
            'section'           => $section,
            'exam'              => $exam

        );

        return view('layouts.admin')->with($variables);
    }

    public function examResult($exam, $students)
    {
        foreach ($students as $key => $student) {
            $entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
            if($entry->active == false)
                $students[$key]['submitted'] = true;
            $students[$key]['score'] = $entry->score;
        }

        return $students;
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

    public function generate_papers(Request $request)
    {
        $exam = Exam::find($request->id);

        $students = Student::where('section', $exam->section_id)->get();

        foreach ($students as $student) {
            $exam_entry = new Exam_Entry();
            $exam_entry->student_id = $student->id;
            $exam_entry->exam_id = $exam->id;
            $exam_entry->active = true;
            $exam_entry->save();
            foreach ($exam->ExamPaper->Tests as $test) {
                $Items = Exam_Item::where('exam_test_id', $test->id)->get(['id']);
                if($Items == null || count($Items) == 0)
                    continue;
                $test_Items = null;
                foreach ($Items as $key => $value) {
                    $test_Items[] = $value->id;
                }
                shuffle($test_Items);
                foreach ($test_Items as $key => $item) {
                    $exam_answer_entry = new Exam_Answer();
                    $exam_answer_entry->answer = null;
                    $exam_answer_entry->correct = false;
                    $exam_answer_entry->exam_entry_id = $exam_entry->id;
                    $exam_answer_entry->exam_item_id = $item;
                    $exam_answer_entry->save();
                }
            }
        }

        $exam->generated_papers = true;
        $exam->save();

        return redirect()->back()->withSuccess('Generated Papers');
    }


    public function studentExamPaper($exam_id, $id)
    {
        $exam = Exam::find($exam_id);
        $exam_paper = $exam->ExamPaper;
        $student = Student::find($id);
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
        $exam_paper['date'] = $exam_entry->date;
        $exam_paper['score'] = $exam_entry->score;
        if(!$exam_entry->active)
            $exam_paper['submitted'] = true;
        else
            $exam_paper['submitted'] = false;

        foreach ($exam_paper->Tests as $key => $test) {
            foreach ($test->Items as $key2 => $item) {
                $answer_entry = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'exam_item_id' => $item->id])->get()->first();
                $item_answers[$item->id] = (object) array(
                    'answer'          => $answer_entry->answer,
                    'answer_entry_id' => '',
                    'correct'         => $answer_entry->correct,
                    'points'          => $answer_entry->points,
                    'name'            => '',
                    'type'            => '',
                    'path'            => '',
                    'id'              => '',
                    'basename'        => ''
                );

                if($test->test_type == 'HandsOn' && $answer_entry->answer != null){
                    $directory = "/".$student->sectionTo->path."/".$student->path."/exam_files";
                    $exam_file = $directory."/".$answer_entry->answer;
                    $file = pathinfo((string)$exam_file."");
                    $temp = explode("item_id=", $file['filename']);
                    $file_id = $temp[1];
                    $file['filename'] = $temp[0];
                    $item_answers[$item->id] = (object) array(
                        'answer_entry_id' => $answer_entry->id,
                        'correct'         => $answer_entry->correct,
                        'points'          => $answer_entry->points,
                        'name'            => $file['filename'],
                        'type'            => $file['extension'],
                        'path'            => $file['dirname'],
                        'id'              => $file_id,
                        'basename'        => $file['basename']
                    );
                }
            }
        }

        $variables = array(
            'dashboard_content' => 'dashboards.admin.exam.show_student_exam_paper',
            'exam'              => $exam,
            'exam_paper'        => $exam_paper,
            'student'           => $student,
            'item_answers'      => $item_answers

        );
        return view('layouts.admin')->with($variables);
    }



    public function saveHandsOnPoints(Request $request)
    {
        $exam_item = Exam_Item::find($request->item_id);
        if($request->points > $exam_item->points)
            return redirect()->back()->withError('Points entered exceed max points of the test item');
        $answer_entry = Exam_Answer::find($request->answer_entry_id);
        $answer_entry->points = $request->points;
        $answer_entry->update();

        $student = Student::find($request->student_id);

        $exam = Exam::where(['section_id' => $student->section, 'exam_paper_id' => $request->exam_paper_id])->get()->first();
        $exam_entry = Exam_Entry::where(['student_id' => $student->id, 'exam_id' => $exam->id])->get()->first();
        $correct_answers = Exam_Answer::where(['exam_entry_id' => $exam_entry->id, 'correct' => true])->get();
        $score = 0;
        if(count($correct_answers) > 0)
            foreach ($correct_answers as $key => $answer_entry) {
                $score += $answer_entry->points;
            }
        $exam_entry->score = $score;
        $exam_entry->update();

        return redirect()->back();
    }


    public function activeStatus($id)
    {

        $exam = Exam::find($id);
        if(!$exam->generated_papers)
            return redirect()->back()->withError('Generate Papers first');

        if($exam->active)
            $exam->active = false;
        else {
            $exam->active = true;
        }

        $exam->update();

        return redirect()->back()->withSuccess('Status changed');
    }


    public function show_to_students($id)
    {

        $exam = Exam::find($id);
        if(!$exam->generated_papers)
            return redirect()->back()->withError('Generate Papers first');
        if($exam->show_to_students)
            $exam->show_to_students = false;
        else {
            $exam->show_to_students = true;
        }

        $exam->update();

        return redirect()->back()->withSuccess('Status changed');
    }


    /*
        ******************

            Exam Paper

        ******************
    */


    public function exam_paper_store(Request $request)
    {
        $this->Validate($request, [
            'perfect_score' => 'integer',
        ]);
        $exam_paper = new Exam_Paper($request->all());
        $exam_paper->save();

        return redirect()->back()->withSuccess('Exam Paper added');
    }



    public function exam_paper_show($id)
    {
        $exam_paper = Exam_Paper::find($id);


        $variables = array(
            'dashboard_content' => 'dashboards.admin.exam.show_exam_paper',
            'exam_paper'        => $exam_paper,
        );

        return view('layouts.admin')->with($variables);
    }

    public function exam_paper_update(Request $request,$id)
    {
        $exam_paper = Exam_Paper::find($id);
        $exam_paper->update($request->all());

        return redirect()->back();
    }



    /*
        ******************

            Exam Test

        ******************
    */

    public function exam_test_store(Request $request)
    {

        $test = new Exam_Test($request->all());
        $test->save();

        return redirect()->back();

    }

    public function exam_test_update(Request $request, $id)
    {

        $test = Exam_Test::find($id);
        $test->update($request->all());

        return redirect()->back();

    }

    public function exam_test_delete($id)
    {

        $test = Exam_Test::find($id);
        $test->delete();

        return redirect()->back();

    }

    /*
        ******************

            Exam Item

        ******************
    */

    public function exam_item_store(Request $request)
    {

        $item = new Exam_Item($request->all());
        if($item->Test->test_type == 'HandsOn'){
            $item->points_type = 'Manual';
        }else {
            $item->points_type = 'Auto';
        }

        $item->save();

        if($item->Test->test_type == 'Multiple Choice' || $item->Test->test_type == 'Identification'){
            $choice = new Exam_Item_Choice();
            $choice->choice = $item->correct_answer;
            $choice->exam_item_id = $item->id;
            $choice->save();
        }

        return redirect()->back();

    }

    public function exam_item_update(Request $request, $id)
    {

        $item = Exam_Item::find($id);
        $prev_answer = $item->correct_answer;
        $item->update($request->all());

        if(($item->Test->test_type == 'Multiple Choice' || $item->Test->test_type == 'Identification') && $prev_answer != $request->correct_answer){
            $choice = new Exam_Item_Choice();
            $choice->choice = $item->correct_answer;
            $choice->exam_item_id = $item->id;
            $choice->save();
        }

        return redirect()->back();

    }

    public function exam_item_delete($id)
    {

        $item = Exam_Item::find($id);
        $item->delete();
        return redirect()->back();

    }



    /*
        ******************

            Exam Item choice

        ******************
    */

    public function exam_item_choice_store(Request $request)
    {
        $choices = explode(" <&&> ", $request->choice);
        foreach($choices as $this_choice){
            $choice = new Exam_Item_Choice();
            $choice->choice = $this_choice;
            $choice->exam_item_id = $request->exam_item_id;
            $choice->save();
        }

        return redirect()->back();
    }

    public function exam_item_choice_update(Request $request, $id)
    {
        $choice = Exam_Item_Choice::find($id);
        $choice->choice = $request->choice;
        $choice->update();

        return redirect()->back();
    }

    public function exam_item_choice_delete($id)
    {
        $choice = Exam_Item_Choice::find($id);
        $choice->delete();

        return redirect()->back();
    }




    /*
        ******************

            Exam Preview

        ******************
    */

    public function previewExam($id, $page)
    {

        $exam_paper = Exam_Paper::find($id);

        $item_list = Exam_Item::where('exam_paper_id', $exam_paper->id)->get();

        if(!isset($item_list[$page]))
            return redirect()->back()->withError('Invalid Item');

        $item_Choices = array();
        $page_max = $page_count = count($item_list);
        $item = $item_list[$page];
        foreach ($item->Choices as $key => $choice) {
            $item_Choices[] = $choice->choice;
        }
        shuffle($item_Choices);
        $variables = array(
            'dashboard_content' => 'dashboards.admin.exam.preview',
            'exam_paper'        => $exam_paper,
            'item_list'         => $item_list,
            'item'              => $item,
            'page'              => $page,
            'page_max'          => $page_max,
            'item_Choices'      => $item_Choices

        );

        return view('layouts.admin')->with($variables);
    }



    public function NextPage(Request $request)
    {

        $page = $request->page;
        if(isset($request->prev))
            $page--;
        else if(isset($request->next))
            $page++;
        else if(isset($request->jump))
            $page = $request->jump;

        return redirect()->route('exam.preview',[$request->exam_paper_id, $page]);
    }



    public function reOpen(Request $request)
    {

        $exam_entry = Exam_Entry::where(['student_id' => $request->student_id, 'exam_id' => $request->exam_id])->get()->first();
        $exam_entry->score = 0;
        $exam_entry->active = true;
        $exam_entry->update();

        return redirect()->back();
    }
}
