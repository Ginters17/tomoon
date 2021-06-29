<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Auth;

class PostController extends Controller
{
    public function search(Request $request){
        // Get the search value from the request
        $search = $request->input('search');
    
        // Search in the title and body columns from the posts table
        $posts = Post::where('text', 'LIKE', "%{$search}%")->get();
    
        // Return the search view with the resluts compacted
        return view('search', compact('posts'));
    }

    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        if (Auth::user()) {   // Check is user logged in
            if (auth()->user()->can('destroy', $comment)) {
                $comment->delete();
                return back();
            }
            if (auth()->user()->cannot('destroy', $comment)) { 
                return redirect('/');
            }
        } else {
            return redirect('/'); 
        }
    }

    public function updateComment(Request $request, $id)
    {
        $rules = array(
            'text' => 'required|min:1|max:800',
        );
        $comment = Comment::findOrFail($id);
        if (Auth::user()) {   // Check is user logged in
            if (auth()->user()->can('update', $comment)) {
                $this->validate($request, $rules);   
                $comment->text = $request->text;
                $comment->save();
                return back();
            }
            if (auth()->user()->cannot('update', $comment)) { return redirect('/'); }
        } else {
            return redirect('/'); 
        }
    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $post = Post::with(['comment' => function($query){
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        $post_views = Post::findOrFail($id);
        $post_views->increment('views');
        return view('post',compact('post'));
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
        $rules = array(
            'text' => 'required|min:1|max:800',
            'post_id' => 
                    'required|exists:posts,id',

        );
        if (Auth::user()) {   // Check is user logged in
            $this->validate($request, $rules);    
            $comment = new Comment();
            $comment->text=$request->text;
            $comment->post_id=$request->post_id;
            $comment->user_id=auth()->id();
            $comment->save();
            return back();
        } else {
            return redirect('/login'); 
        }
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
        $rules = array(
            'text' => 'required|min:1|max:800',
        );
        $post = Post::findOrFail($id);
        if (Auth::user()) {   // Check is user logged in
            if (auth()->user()->can('update', $post)) {
                $this->validate($request, $rules);   
                $post->text = $request->text;
                $post->save();
                return back();
            }
            if (auth()->user()->cannot('update', $post)) { return redirect('/'); }
        } else {
            return redirect('/'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Post::findOrFail($id)->delete();
        $post = Post::findOrFail($id);
        if (Auth::user()) {   // Check is user logged in
            if (auth()->user()->can('destroy', $post)) {
                $post->delete();
                return redirect('/'); 
            }
            if (auth()->user()->cannot('destroy', $post)) { return redirect('/'); }
        } else {
            return redirect('/'); 
        }
       
    }

}