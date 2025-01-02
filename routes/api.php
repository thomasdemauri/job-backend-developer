<?php

use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class)->missing(function () {
    return response()->json(['message' => 'Product not found.'], 404);
});

Route::get('products/name/{name}/category/{category}', [ProductController::class, 'showByNameAndCategory']);
Route::get('products/name/{name}', [ProductController::class, 'showByName']);
Route::get('products/category/{category}', [ProductController::class, 'showByCategory']);