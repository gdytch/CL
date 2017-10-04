<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        if (!File::exists(public_path().'/'.$path))
        {
            File::makeDirectory(public_path().'/'.$path,0777,true);
        }

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
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.section.show')->with('section', $section);
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
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.section.edit')->with('section', $section);
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
        if($section->path != $request->path){
            File::move(public_path()."\\storage\\".$section->path, public_path().'\\storage\\'.$request->path);

        }
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

    public function changeStatus($id){
        $section = Section::find($id);

        if($section->status)
            $section->status = 0;
        else
            $section->status = 1;
        $section->save();

        return redirect()->back()->withSuccess($section->name.' status changed');
    }
}
