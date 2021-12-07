<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('posts')->get();
        $users = DB::table('users')->get();

        $posts = DB::table('posts')
                  ->leftJoin('users','posts.author','=','users.id')
                  ->select('posts.*','users.name')
                  ->paginate(3);

        return view('posts.index',['posts'=>$posts,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){
          return redirect()->back()->with('status','You Must Be Logged In to Continue');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->text = $request->text;
        $post->author = $request->author;
        $path = $request->file('image')->store('public/images');
        //$path = Storage::putFileAs('public/images',$request->file('image'),$request->user()->id);
        $post->images = $path;
        $post->save();

        //Session::flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::check()){
        return redirect()->back()->with('status','You Must Be Logged In to Continue');
      }
        $post = Post::find($id);
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->text = $request->text;
        $post->author = $request->author;

        if($request->file('image') != null){
          Storage::delete($post->images);
          $path = $request->file('image')->store('public/images');
          $post->images = $path;
        }

        $post->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::check()){
        return redirect()->back()->with('status','You Must Be Logged In to Continue');
      }
        $post = Post::find($id);
        Storage::delete($post->images);
        $post->delete();

        return redirect()->back();
    }
}
