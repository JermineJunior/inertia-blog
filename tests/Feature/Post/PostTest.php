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

it("belongs to a user", function () {
    //arrange
    $user = User::factory()->create();
    $post = Post::factory()->create([
        "user_id" => $user->id,
    ]);
    //act
    //assert
    expect($post->user->is($user))->toBeTrue();
});

// post creation
test("the create page is displayed", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get("/posts/create");

    $response->assertOk();
    $response->assertStatus(200);
});

it("dosent allow unauthinticated users to visit the  create form", function () {
    $response = $this->get("/posts/create");

    $response->assertRedirectToRoute("login");
});

it("dosent allow unauthinticated users to create new posts", function () {
    $user = User::factory()->create();

    $post = [
        "user_id" => $user->id,
        "title" => "new title",
        "body" => "new body",
    ];
    $response = $this->post("/posts", $post);

    $response->assertFound();
});

it("allows authinticated  users to create new posts", function () {
    $user = User::factory()->create();
    $post = [
        "user_id" => $user->id,
        "title" => "new title",
        "body" => "new body",
    ];
    $response = $this->actingAs($user)->post("/posts", $post);

    $this->assertDatabaseHas("posts", [
        "title" => "new title",
        "body" => "new body",
    ]);
});
