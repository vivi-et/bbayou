<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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

        $this->validate(request(), [
            'title' => 'required|max:20', // 최대 10글자
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);


        session()->flash('message', 'Post Created!');


        // server side validation (null 체크 등)
        // $this->validate(request(),[
        //     'title'=>'required|max:10', // 최대 10글자
        //     'body'=>'required'
        // ]);

        //Handle file upload
        if ($request->hasFile('cover_image')) {

            //Get Filename with extension

            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // $test = 0;
        // if ($test = 1)
        //     $fileNameToStore = 'abcd.png';
        // $a = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');
        // // $a = "tesseract /home/viviet/bbayou/public/storage/cover_images/ . $fileNameToStore . stdout -l kor";

        //Post::create(request(['title','body']));
        //auth()->user()->publish(new Post(request([title',body'])));

        // $a = str_replace("\n", "\\n\n", $a);
        // $a = str_replace("\t", "\\t\t", $a);

        // $a = explode('', $a);


        Post::create([
            'title' => request('title'),
            'body' => request('body'),
            'body' => request('title'),
            // 'body' => $a,
            'user_id' => auth()->id(),
            'cover_image' => $fileNameToStore,

            //auto saved!
        ]);

        return redirect('/post');
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
        return view('post.edit', compact('post'));
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
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->withErrors('error', 'Unauthorized Page');
        }
        // PATCH /tasks/id

        $this->validate(request(), [
            'title' => 'required|max:20', // 최대 10글자
            'body' => 'required'
        ]);

        //Handle file upload
        if ($request->hasFile('cover_image')) {

            //Get Filename with extension

            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }



        $post->update($request->all());
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/post');
        // $post->update($request->all());


        // $post->title = $request->input('title');
        // $post->body = $request->input('body');
        // $post->save();


        // $update = Post::find($post->id);

        // Post::create([
        //     'title' => request('title'),
        //     'body'=> request('body'),
        //     'user_id'=> auth()->id(),
        // ]);

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

        $post->delete();


        return redirect('/');
    }
}
