<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", [AuthController::class, "LoginPage"])->name("page.login");
Route::post("/login", [AuthController::class, "Login"])->name("process.login");
Route::get("/register", [AuthController::class, "RegisterPage"])->name("page.register");
Route::post("/register", [AuthController::class, "Register"])->name("process.register");

Route::prefix("/admin")->group(function() {
    Route::get("/users", [UserController::class, "ListUserPage"])->name("page.admin.list_user");
    Route::get("/users/{id}/delete", [UserController::class, "DeleteUser"])->name("process.admin.delete_user");

    Route::get("/books", [BookController::class, "GetList"])->name("page.admin.list_book");
    Route::get("/books/add", [BookController::class, "AddBookPage"])->name("page.admin.add_book");
    Route::post("/books/add", [BookController::class, "AddBook"])->name("process.admin.add_book");
    Route::get("/books/{id}/delete", [BookController::class, "DeleteBook"])->name("process.admin.delete_book");
    Route::get("/books/{id}/edit", [BookController::class, "EditBookPage"])->name("page.admin.edit_book");
    Route::post("/books/{id}/edit", [BookController::class, "EditBook"])->name("process.admin.edit_book");

    Route::get("/categories", [BookCategoryController::class, "GetList"])->name("page.admin.list_category");
    Route::get("/categories/add", [BookCategoryController::class, "AddCategoryPage"])->name("page.admin.add_category");
    Route::post("/categories/add", [BookCategoryController::class, "AddCategory"])->name("process.admin.add_category");
    Route::get("/categories/{id}/delete", [BookCategoryController::class, "DeleteCategory"])->name("process.admin.delete_category");
    Route::get("/categories/{id}/edit", [BookCategoryController::class, "EditPageCategory"])->name("page.admin.edit_category");
    Route::post("/categories/{id}/edit", [BookCategoryController::class, "EditCategory"])->name("process.admin.edit_category");
});