<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $follows = DB::table('follows')
            ->join('users', 'users.id', "=", 'follows.to_user')
            ->where('follows.user_id', '=', auth()->user()->id)
            ->get();

        $messages = DB::table('messages')->get();
        $users = DB::table('users')->get();

        return view('messages.index', ['follows' => $follows, 'messages' => $messages, 'users' => $users]);
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
        $message = new Message();

        $message->message = $request->comment;
        $message->user_id = auth()->user()->id;
        $message->to_user_id = $request->to_user_id;

        $message->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function talk($user)
    {
        $user = DB::table('users')
            ->where('name', '=', $user)
            ->first();

        $messages = DB::table('messages')->get();

        return view('messages.talk', ['user' => $user, 'messages' => $messages]);
    }
}
