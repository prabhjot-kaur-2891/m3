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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('shortUrl', [ShortnerController::class, 'store']);

// Route::post('/shortUrl', function(Request $request) {
//     return ShortnerController::store($request->all);
// });

//Route::post('/shortUrl/{url}/{expiry?}', 'ShortnerController@getShortUrl');