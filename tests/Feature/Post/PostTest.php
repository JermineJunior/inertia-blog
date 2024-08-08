<?php
use App\Models\Post;
use App\Models\User;

describe('stability', function () {
    test('guest stability', function ($url) {
        $this->get($url)->assertOk();
    })->with(['/', '/posts', '/contact']);


    test('auth stability', function ($url) {
        $user = User::factory()->create();
        $this->actingAs($user)->get($url)->assertOk();
    })->with(['/dashboard', '/profile', '/posts/create']);
});
describe('Post Crud', function () {

    it("shows a posts title in the index page", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $response = $this->actingAs($user)->get("/posts");

        $response->assertOk();
        $response->assertSee($post->title);
    });

    it("shows a posts body in the index page", function () {
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

    it("has a path", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            "user_id" => $user->id,
        ]);

        expect($post->path())->toBe("/posts/" . $post->id);
    });

    // post creation
    test("the create page is displayed", function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/posts/create");

        $response->assertOk();
        $response->assertStatus(200);
    });

    it("doesn't allow unauthenticated users to visit the  create form", function () {
        $response = $this->get("/posts/create");

        $response->assertRedirectToRoute("login");
    });

    it("doesn't allow unauthenticated users to create new posts", function () {
        $user = User::factory()->create();

        $post = [
            "user_id" => $user->id,
            "title" => "new title",
            "body" => "new body",
        ];
        $response = $this->post("/posts", $post);

        $response->assertFound();
    });

    it("allows authenticated  users to create new posts", function () {
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
        $this->assertDatabaseCount("posts", 1);
    });

    test("unauthenticated users cant view a single posts", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            "user_id" => $user->id,
        ]);

        $response = $this->get($post->path());
        $response->assertStatus(302);
    });

    test("users can view a single post", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($user)->get($post->path());
        $response->assertOk();
        $response->assertStatus(200);
    });

    test("post owners can visit the edit page", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($user)->get($post->path() . "/edit");
        $response->assertOk();
    });

    test("post owners can update post details", function () {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            "user_id" => $user->id,
            "title" => "old title",
            "body" => "old body",
        ]);

        $response = $this->actingAs($user)->put("/posts/" . $post->id, [
            "user_id" => $user->id,
            "title" => "new title",
            "body" => "new body",
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect("/posts");

        $post->refresh();
        expect($post->title)->toBe("new title");
        expect($post->body)->toBe("new body");
    });
});
