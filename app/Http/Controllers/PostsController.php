<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $postQuery = Post::query();
        $this->applySearch($postQuery, request()->search);
        $posts = PostResource::collection(
            $postQuery->paginate(8)
        );
        return Inertia("Post/Index", [
            "posts" => $posts,
            'search' => request()->search ?? ''
        ]);
    }

    public function userPosts()
    {
        $posts = PostResource::collection(auth()->user()->posts);
        return inertia('Dashboard', ["posts" => $posts]);
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
    public function store(StorePostRequest $request): RedirectResponse
    {
        //validate the form request
        $request->validated();
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
        $newPost = new PostResource($post);
        $canEdit = Gate::allows("update-post", $post);
        return Inertia::render("Post/Show", [
            "post" => $newPost,
            "canEdit" => $canEdit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $newPost = new PostResource($post);
        return Inertia::render("Post/Edit", [
            "post" => $newPost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post)
    {
        //validate the form request
        request()->validate(
            [
                "title" => "required|max:255",
                "body" => "required",
            ]
        );
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
        $post->delete();

        return redirect()->route("posts");
    }

    protected function applySearch($query, $search)
    {
        //return results filtered by name
        $query->when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
