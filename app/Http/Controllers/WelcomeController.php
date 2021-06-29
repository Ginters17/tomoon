<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

/// WelcomeController for my new welcome page, may be bad code
class WelcomeController extends Controller
{

    public function index()
    {
        $posts=Post::all()->sortByDesc('created_at');
        return view('mywelcome', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $book = Book::create([
            'title' => 'Anna Karenina',
            'authors' => 'Leo Tolstoy',
            'year' => 1878]);
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
        );
        if(Auth::user()){
            $this->validate($request, $rules);
            $post = new Post();
            $post->text=$request->text;
            $post->user_id=auth()->id();
            $post->views=0;
            $post->save();
            return redirect('/');
        }
        else{
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
        $book = Book::findorfail($id);
        echo $book->title;
        echo "<br>";
        echo $book->authors;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        $book->abstract = "The story centers onan extramarital affair between Anna and dashing cavalry officer Count Alexei Kirillovich Vronsky";
        $book->save();
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
}
