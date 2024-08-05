<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia("Post/Index", [
            "posts" => Post::latest()
                ->get()
                ->map(function ($post) {
                    return [
                        "id" => $post->id,
                        "title" => $post->title,
                        "body" => $post->body,
                        "user" => $post->user->name,
                        "path" => $post->path(),
                    ];
                }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia("Post/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //validate the form request
        request()->validate([
            "title" => ["required", "min:3"],
            "body" => ["required", "max:500"],
        ]);
        //presets the validated record to the database
        Post::create([
            "user_id" => auth()->id(),
            "title" => request("title"),
            "body" => request("body"),
        ]);
        //redirect to the Index page
        return redirect(route("posts"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Inertia::render("Post/Show", [
            "post" => [
                "id" => $post->id,
                "title" => $post->title,
                "body" => $post->body,
                "user" => $post->user->name,
                "path" => $post->path() . "/edit",
                "canEdit" => Gate::allows("update-post", $post),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render("Post/Edit", [
            "post" => [
                "id" => $post->id,
                "title" => $post->title,
                "body" => $post->body,
                "user" => $post->user->name,
                "path" => $post->path(),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //validate the form request
        request()->validate([
            "title" => ["required", "min:3"],
            "body" => ["required", "max:500"],
        ]);
        //presets the validated record to the database
        $post->update([
            "user_id" => auth()->id(),
            "title" => request("title"),
            "body" => request("body"),
        ]);
        //redirect to the Index page
        return redirect(route("posts"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
