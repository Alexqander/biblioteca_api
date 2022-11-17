<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Authentication is not required for these endpoints
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('userProfile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::put('changePassword', [AuthController::class, 'changePassword']);
    Route::post('createReview', [BookController::class, 'addBookReview']);
    Route::put('updateReview/{id}', [BookController::class, 'updateBookReview']);
});
Route::prefix('book')->group(function () {
    Route::get('index', [BookController::class, 'index']);
    Route::get('show/{id}', [BookController::class, 'show']);
    Route::post('store', [BookController::class, 'store']);
    Route::put('update/{id}', [BookController::class, 'update']);
    Route::delete('delete/{id}', [BookController::class, 'destroy']);
});
