<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Auth;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessage($id)
    {
        $message = Message::findOrFail($id);
        $sender_id=$message->sender_id;
        $sender= User::findOrFail($sender_id);
        if (Auth::user()) {   // Check is user logged in
            if (auth()->user()->can('showMessage', $message)) { 
                return view('show_message',compact('message'),compact('sender'));
            }
            if (auth()->user()->cannot('showMessage', $message)) { 
                return redirect('/'); 
            }
        } else {
            return redirect('/'); 
        }
    }
    public function sendMessage($id)
    {
        if (!Auth::user()) return redirect ('/login');
        $user = User::findOrFail($id);
        return view('send_message',compact('user'));
    }

    public function index()
    {
        if (!Auth::user()) return redirect ('/login');
        $id = Auth::user()->id;
        $messages=Message::where('receiver_id', $id)->get();
        //$users=User::where('id', $id)->get();
        return view('messages', compact('messages'));
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
            'subject' => 'required|min:1|max:100',
        );
        if(Auth::user()){
            $this->validate($request, $rules);
            $message = new Message();
            $message->text=$request->text;
            $message->subject=$request->subject;
            $message->sender_id=auth()->id();
            $message->receiver_id=$request->receiver_id;
            $message->save();
            return back();
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
}
