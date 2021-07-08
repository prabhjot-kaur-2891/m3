<?php

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

use App\Http\Controllers\ShortnerController;
use App\Http\Controllers\UrlController;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('shortUrl', [ShortnerController::class, 'store']);
Route::post('shortUrls', [UrlController::class, 'store']);
