<?php

namespace App\Http\Controllers;

use App\Models\LikeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeCommentController extends Controller
{
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
        $likecomment = new LikeComment();

        $likecomment->user_id = auth()->user()->id;
        $likecomment->comment_id = $request->comment_id;

        $likecomment->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LikeComment  $likeComment
     * @return \Illuminate\Http\Response
     */
    public function show(LikeComment $likeComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LikeComment  $likeComment
     * @return \Illuminate\Http\Response
     */
    public function edit(LikeComment $likeComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LikeComment  $likeComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LikeComment $likeComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LikeComment  $likeComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LikeComment $likeComment)
    {
        //
    }

    public function deslikecomment(Request $request)
    {
        DB::table('like_comments')
            ->where('id', '=', $request->likecomment_id)
            ->delete();

        return back();
    }
}
