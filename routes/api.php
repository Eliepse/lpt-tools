<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\FetchCachedChineseListsController;
use App\Http\Controllers\Api\PrepareGridCNController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/lists/chinese', FetchCachedChineseListsController::class);
Route::post('/grid/chinese', PrepareGridCNController::class);

Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"]);


Route::middleware(["auth:sanctum"])->group(function () {
	Route::get("/me", fn() => Auth::user());
	Route::get("/courses", [CourseController::class, "index"]);
	Route::post("/courses", [CourseController::class, "store"]);
	Route::put("/courses/{course}", [CourseController::class, "update"]);
	Route::delete("/courses/{course}", [CourseController::class, "destroy"]);
});