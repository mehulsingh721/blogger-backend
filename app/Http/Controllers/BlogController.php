<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs, 200);
    }

    public function getUserBlogs(Request $request)
    {
        $userId = $request->query("userId");
        $user = User::find($userId);
        $blogs = Blog::where("user_id", $userId)->get();
        return response()->json(["blogs" => $blogs, "username" => $user->name], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->query("userId");
        $user = User::find($userId);
        $blog = Blog::create([
            "title" => $request->title,
            "excerpt" => $request->excerpt,
            "body" => $request->body,
            "author" => $user->name,
            "user_id" => $userId
        ]);
        return response()->json($blog, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->query("blogId");
        $blog = Blog::find($id);
        return response()->json($blog, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->query("blogId");
        $blog = Blog::find($id);
        $blog->update($request->all());
        return response()->json($blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->query("blogId");
        Blog::destroy($id);
        return response()->json("Deleted User", 200);
    }
}
