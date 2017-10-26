<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('created_at', 'desc')->get();
        $post_list = null;
        foreach ($posts as $post) {
            $activity_list = array();
            foreach ($post->Activities as $activity) {
                $activity_list[] = "".$activity->name." ".$activity->SectionTo->name." • ";
            }

            $post_list[] = (object) array(
            'id' => $post->id,
            'title' => $post->title,
            'draft' => $post->draft,
            'body' => $post->body,
            'created_at' => date("M d Y", strtotime($post->created_at)),
            'activity_list' => $activity_list
            );
        }

        $variables = array(
            'dashboard_content' => 'dashboards.admin.post.index',
            'posts' => $posts,
            'post_list' => $post_list
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

        $activities = Activity::where('post_id', null)->orderBy('name', 'asc')->get();
        $message_info = null;

        if (env('APP_URL') == 'https://computerclassapp.herokuapp.com/') {
            $message_info_per = "Uploaded images are deleted in every dyno restarts, you can your images in google drive or other cloud storage and paste the image url. ";
        } else {
            $message_info_per = null;
        }
        $variables = array(
            'dashboard_content' => 'dashboards.admin.post.create',
            'activities' => $activities,
            'message_info_per' => $message_info_per
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

        $post = new Post();

        $post->title = $request->title;
        $post->body = $request->content;
        if ($request->draft) {
            $post->draft = true;
        } else {
            $post->draft = false;
        }
        $post->save();


        if ($request->activity != null) {
            foreach ($request->activity as $value) {
                $activity = Activity::find($value);
                $activity->post_id = $post->id;
                $activity->update();
            }
        }

        return redirect()->route('post.edit', $post->id)->withSuccess('Post Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Post::find($id);

        $variables = array(
            'dashboard_content' => 'dashboards.admin.post.show',
            'post' => $post,
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

        $post = Post::find($id);
        $checked_activities = $post->Activities()->orderBy('name', 'asc')->get();
        $unchecked_activities = Activity::where('post_id', null)->orderBy('name', 'asc')->get();

        $variables = array(
            'dashboard_content' => 'dashboards.admin.post.edit',
            'checked_activities' => $checked_activities,
            'unchecked_activities' => $unchecked_activities,
            'post' => $post
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

        $post = Post::find($id);
        $post->title = $request->title;
        $post->body = $request->content;
        if ($request->draft) {
            $post->draft = true;
        } else {
            $post->draft = false;
        }
        $post->update();

        //reset checked_activities
        $checked_activities = $post->Activities()->orderBy('name', 'asc')->get();
        if (count($checked_activities) != 0) {
            foreach ($checked_activities as $activity) {
                $activity = Activity::find($activity->id);
                $activity->post_id = null;
                $activity->update();
            }
        }

        if ($request->activity != null) {
            foreach ($request->activity as $value) {
                $activity = Activity::find($value);
                $activity->post_id = $post->id;
                $activity->update();
            }
        }

        return redirect()->route('post.edit', $post->id)->withSuccess('Post Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::find($id);
        $post->delete();

        return redirect()->route('post.index')->withSuccess('Post deleted');
    }
}
