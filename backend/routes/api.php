<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReceipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//get all receipes 
Route::get("/receipes",[ReceipController::class,'index']);

//get single receipe 
Route::get("/receipes/{id}",[ReceipController::class,"show"]);

// create new receipes
Route::post("/receipes",[ReceipController::class,"store"]);

//Update single receipe 
Route::patch("/receipes/{id}",[ReceipController::class,"update"]);

// upload photo api
Route::post("/receipes/upload",[ReceipController::class,"upload"]);

// delete single receip
Route::delete("/receipes/{id}",[ReceipController::class,"destory"]);


//get all categories
Route::get("/categories",[CategoryController::class,"index"]);

