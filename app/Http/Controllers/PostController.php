<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        //tasks
        return view('post.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // tasks/create
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // POST /tasks

        // dd(request()->all());

        // method 1
        // $post = new Post;
        // $post->title = request('title');
        // $post->body = request('body');

        // $post->save();

            $this->validate(request(),[
            'title'=>'required|max:10', // 최대 10글자
            'body'=>'required'
        ]);

        //Post::create(request(['title','body']));
        //auth()->user()->publish(new Post(request([title',body'])));
        Post::create([
            'title' => request('title'),
            'body'=> request('body'),
            'user_id'=> auth()->id(),

            //auto saved!
        ]);

        return redirect('/');

        // server side validation (null 체크 등)
        // $this->validate(request(),[
        //     'title'=>'required|max:10', // 최대 10글자
        //     'body'=>'required'
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //GET /tasks/id
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // GET /tasks/id/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // PATCH /tasks/id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // DELETE /tasks/id
    }
}
