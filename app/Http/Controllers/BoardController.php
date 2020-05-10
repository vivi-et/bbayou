<?php

namespace App\Http\Controllers;

use App\Board;
use App\Post;
use DB;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $board)
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

        $posts = Post::select('posts.*')
            ->Join('boards', 'boards.id', '=', 'posts.board_id')
            ->where('board_name', $board)
            ->orderby('id','desc')
            ->paginate(5);


        return  view('board.index')->with('posts', $posts)->with('boardname',$boardname)->with('board',$board);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
    }
}
