<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts =  Post::with('category','user')->paginate(5);
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories =  Category::all();
        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        //
        $tags =  explode(',',$request->tags);
        $filename = '';
        if($request->has('image')){
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs( 'uploads/posts', $filename,'public');
        }

        $post = auth()->user()->posts()->create([
            'title'=>$request->title,
            'image'=>$filename,
            'post'=>$request->post,
            'category_id'=> $request->category
        ]);

        foreach($tags as $tagName){
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {

    //}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories =  Category::all();
        $tags = $post->tags->implode('name',',');
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request,Post $post)
    {
        if($request->has('image')){
            if (Storage::exists('public/uploads/posts/'.$post->image)) {
                Storage::delete('public/uploads/posts/'.$post->image);
            }
            $filename =  time().'-'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads/posts/',$filename,'public');
        }
        $post->update([
            'title' => $request->title,
            'post' =>$request->post,
            'image' =>$filename ?? $post->image,
            'category_id'=>$request->category
        ]);
        $tags =  explode(',',$request->tags);
        $new_tags = [];
        foreach($tags as $tag){
            $tag = Tag::FirstOrCreate(['name'=>$tag]);
            array_push($new_tags,$tag->id);
        }
        $post->tags()->sync($new_tags);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image){
            if (Storage::exists('public/uploads/posts/'.$post->image)) {
                Storage::delete('public/uploads/posts/'.$post->image);
            }
        }
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
