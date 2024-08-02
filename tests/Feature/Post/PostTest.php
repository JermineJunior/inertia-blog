<?php
use App\Models\Post;
use App\Models\User;

test("Index page is displayed", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get("/posts");

    $response->assertOk();
});

it("shows a posts title in the index page", function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $response = $this->actingAs($user)->get("/posts");

    $response->assertOk();
    $response->assertSee($post->title);
});

it("shows a  posts body in the index page", function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $response = $this->actingAs($user)->get("/posts");

    $response->assertOk();
    $response->assertSee($post->body);
});
