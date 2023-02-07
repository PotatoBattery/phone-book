<?php

use App\Http\Controllers\Api\PhoneBook\V1\ApiContactController;
use App\Http\Controllers\Api\PhoneBook\V1\ApiNumberController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('/v1')->group(function (){
    Route::prefix('/phone-book')->middleware('auth:api')->group(function (){
        Route::apiResource('/contacts', ApiContactController::class);
        Route::patch('/contacts/favorite/{contact}', [ApiContactController::class, 'favorite'])->name('contacts.favorite');
        Route::get('/favorite/contacts', [ApiContactController::class, 'indexFavorite'])->name('contacts.favorite.index');
        Route::apiResource('/numbers', ApiNumberController::class)->only(['destroy']);
    });
});
