<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Auth;
use App\Student;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except('showLoginForm','login');
    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function showLoginForm(){
        if(Auth::guard('admin')->check())
            return redirect('admin');
        return view('dashboards.admin.pages.login');
    }

    public function home(){
        return view('layouts.admin')->with('dashboard_content', 'dashboards.admin.pages.home');
    }

    public function login(Request $request){

      //Validate the form data
      $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
      ]);
      //if validated
      if(Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])){
        return redirect()->intended('admin');
      }

      return redirect()->back()->withInput($request->only($this->username()))->withErrors('Invalid credentials');

    }

    public function username()
    {
        return 'username';
    }

    
}
