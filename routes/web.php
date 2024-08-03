<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/", function () {
    return Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ]);
});
//dashboard
Route::get("/dashboard", function () {
    return Inertia::render("Dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");
//Auth Routes
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );
});
//
Route::get("/contact", function () {
    return Inertia::render("Contact");
});
//Posts

Route::middleware("auth")->group(function () {
    Route::get("/posts", [PostsController::class, "index"])->name("posts");
    Route::get("/posts/create", [PostsController::class, "create"])->name(
        "posts.create"
    );
    Route::post("/posts", [PostsController::class, "store"])->name(
        "posts-create"
    );
});
require __DIR__ . "/auth.php";
