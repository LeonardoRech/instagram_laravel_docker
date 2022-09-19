<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function profile($user)
    {
        $user = User::where("name", "=", $user)->firstOrFail();

        $posts = Post::where("user_id", "=", $user->id)->get();

        $authfollows = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['to_user', '=', $user->id]
        ])->first();

        $follows = Follow::where('user_id', '=', $user->id)->get();
        $tofollows = Follow::where('to_user', '=', $user->id)->get();

        $comments = DB::table('comments')->get();
        $users = DB::table('users')->get();
        $likecomments = DB::table('like_comments')->get();

        return view('user.profile', ['authfollows' => $authfollows, 'tofollows' => $tofollows, 'follows' => $follows, 'likecomments' => $likecomments, 'user' => $user, 'posts' => $posts, 'comments' => $comments, 'users' => $users]);
    }
}
