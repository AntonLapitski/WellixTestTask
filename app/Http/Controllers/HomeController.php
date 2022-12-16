<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 13.12.22
 * Time: 13.25
 */

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('welcome', [
            'posts' => $posts
        ]);
    }


    public function blogAfterLogin(Request $request)
    {

        $posts = Post::all();
        $userName = Auth::guard('api')->user()->name;

        return view('blog', [
            'posts' => $posts,
            'userName' => $userName
        ]);
    }

    public function editItem(Request $request)
    {

        $post = Post::find($request->get('postId'));

        return view('edit', [
            'post' => $post
        ]);
    }
}
