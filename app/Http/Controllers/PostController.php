<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index(){
        $posts =  Post::latest()->get();
        return view('posts.index',compact('posts'));

        // $posts = Post::with('tags', 'category')->latest()->paginate(12);

        // return view('posts.index', compact('posts'));
    }

    public function show($id){
        $post = Post::with('tags', 'category')->findOrFail($id);
        return view('posts.show',compact('post'));

    }


}
