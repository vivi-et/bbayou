<?php

namespace App\Http\Controllers;

use App\Post;
use App\Giftcon;
use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
    public function index(string $board)
    {


        $posts = Post::latest()->get();
        //tasks
        return view('post.freeboard', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $board)
    {
        switch ($board) {
            case 'free':
                $boardname = '자유게시판';
                break;
            case 'humor':
                $boardname = '유머게시판';
                break;
            case 'game':
                $boardname = '게임게시판';
                break;
            case 'sport':
                $boardname = '스포츠게시판';
                break;
            default:
                $boardname = 'error';
                break;
        }

        return view('post.create')->with('board', $board)->with('boardname', $boardname);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $board = $request->board;
        $boardno = Board::where('board_name', $board)->first()->value('id');

        $this->validate($request, [

            'title' => 'required',
            'body' => 'required',

        ]);

        $body = $request->input('body');

        $dom = new \DomDocument();

        $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');

            list($type, $data) = explode(';', $data);

            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);

            $image_name = "/upload/" . $board .time() . $k . '.png';

            $path = public_path() . $image_name;

            file_put_contents($path, $data);

            $img->removeAttribute('src');

            $img->setAttribute('src', $image_name);
        }

        $body = $dom->saveHTML();




        $board = $request->board;
        $boardno = Board::where('board_name', $board)->first()->value('id');


        Post::create([
            'title' => $request->title,
            'body' => $body,
            'user_id' => auth()->id(),
            'board_id' => $boardno,
        ]);


        return redirect('/board/' . $board);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $blogkey = 'blog_' . $post->id;

        //조회수 1증가
        if (!Session::has($blogkey)) {
            $post->increment('views');
            Session::put($blogkey, 1);
        }




        return view('post.show')->with('post', $post);
        // return view('post.show', compact('package'));
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

        //삭제할 파일 이름 가져오기
        $fileNameToStore = $post->cover_image;
        $path = 'storage/cover_images/' . $fileNameToStore;

        //기프티콘 파일 삭제
        unlink($path);

        //게시글 삭제
        $post->delete();

        //연결된 기프티콘 항목도 삭제
        $orderno = $post->hasGiftconOrderNO;
        $giftconID = Giftcon::where('orderno', $orderno)->first()->id;
        $giftcon = Giftcon::find($giftconID);
        $giftcon->delete();

        return redirect('/post');
    }
}
