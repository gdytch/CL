<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Section;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $variables = array(
            'dashboard_content' => 'dashboards.admin.section.show',
            'section' => $section
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



    public function changeStatus($id)
    {

        $section = Section::find($id);

        if($section->status){
            $section->status = 0;
            $section->save();
            return redirect()->back()->withError('CLOSED - '.$section->name.'');
        }
        else{
            $section->status = 1;
            $section->save();
            return redirect()->back()->withSuccess('OPENED - '.$section->name.'');
        }

    }



    public function folder($id)
    {

        $section = Section::find($id);
        $directory = public_path()."\\storage"."\\".$section->path;

        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') && !(file_exists($directory))) {
            $msg = array("Cannot open folder", "This function only works on a local server running in Windows");
            return redirect()->back()->withErrors($msg);
        }

        $explorer =  'c:\\windows\\explorer.exe';
        shell_exec("$explorer /n,/e,$directory");

        return redirect()->back();

    }


}
