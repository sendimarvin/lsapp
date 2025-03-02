<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::orderBy('title', 'id')->paginate(10);
        return view('posts.index')
            ->with(compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request, 
            [
                'title' => "Required",
                'body' => "Required",
                'cover_image' => "image|nullable|max:1999"
            ]
        );

        if ($request->hasFile('cover_image')) {
            $file_name_with_extension = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($file_name_with_extension , PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $file_name_to_store = $filename . "_" . time() . "." . $extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $file_name_to_store);
        } else {
            $file_name_to_store = 'no_image.jpg';
        }


        $post = new Post();

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $file_name_to_store;

        $post->save();

        return redirect('/posts')
            ->with('success', "Post created successfully");

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
        return view('posts.show')
            ->with(compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Post::find($id);

        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')
                ->with('error', 'Unauthorized Page');
        }
        
        return view('posts.edit')
            ->with(compact('post'));

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
        $this->validate($request, 
            [
                'title' => "Required",
                'body' => "Required",
                'cover_image' => "image|nullable|max:1999"
            ]
        );


        if ($request->hasFile('cover_image')) {
            $file_name_with_extension = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($file_name_with_extension , PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $file_name_to_store = $filename . "_" . time() . "." . $extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $file_name_to_store);
        } else {
            $file_name_to_store = 'no_image.jpg';
        }


        $post = Post::find($id);

        

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // $post->cover_image = $file_name_to_store;

        $post->save();

        return redirect('/posts')
            ->with('success', "Post Upated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')
                ->with('error', 'Unauthorized Page');
        }

        $post->delete();

        return redirect('/posts')
            ->with('success', "Post removed");
    }
}
