<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        if ($request->has('thumbnail')) {
            $thumbnail = $request->thumbnail;
            $name = $thumbnail->getClientOriginalName();
            $path = public_path('uploads/images/');
            $thumbnail->move($path, $name);
        }

        // return Post::create($request->all());
        return Post::create([
            'title' => $request->title,
            'author' => $request->author,
            'date' => $request->date,
            'description' => $request->description,
            'thumbnail' => $name
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Post::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function upload(Request $request)
    {
        if ($request->has('thumbnail')) {
            $thumbnail = $request->thumbnail;
            $name = time().'.'.$thumbnail->getClientOriginalExtension();
            $path = public_path('uploads/images/');
            $thumbnail->move($path, $name);
            return response()->json(['data'=>'','message'=>'Image uploaded successfully','status'=>true],200);
        }
    }

    /**
     * Search for title
     * @param str $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Post::where('title', 'like', '%'.$title.'%')->get();
    }
}
