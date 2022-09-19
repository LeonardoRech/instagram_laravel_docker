<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $user = auth()->user();

        $posts = DB::table('follows')
            ->join('users', 'users.id', "=", 'follows.to_user')
            ->join('posts', 'posts.user_id', '=', 'follows.to_user')
            ->where('follows.user_id', '=', auth()->user()->id)
            ->get();

        $comments = DB::table('comments')->get();
        $likecomments = DB::table('like_comments')
            ->get();

        $users = DB::table('users')->get();

        $newusers = DB::table('users')
            ->orderby('created_at')
            ->limit('4')
            ->get();

        $likes = DB::table('likes')
            ->where('likes.user_id', '=', auth()->user()->id)
            ->get();

        $follows = DB::table('follows')
            ->join('users', 'users.id', "=", 'follows.to_user')
            ->where('follows.user_id', '=', auth()->user()->id)
            ->get();

        $messages = DB::table('messages')->get();

        return view('dashboard', ['newusers' => $newusers, 'messages' => $messages, 'follows' => $follows, 'users' => $users, 'user' => $user, 'posts' => $posts, 'comments' => $comments, 'likes' => $likes, 'likecomments' => $likecomments]);
    }
}
