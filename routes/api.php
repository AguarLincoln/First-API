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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/teste', function(Request $request){
    dd($request->headers->all());
    $response =  new \Illuminate\Http\Response(json_encode(['msg' => 'meu retorno']));
    $response->header('Content-Type','aplication/json');
    return $response;
});

Route::namespace('Api')->group(function(){

    Route::prefix('products')->group(function(){
        Route::get('/', 'ProductController@index');
        Route::get('/{id}', 'ProductController@show');
        //Route::post('/', 'ProductController@save')->middleware('auth.basic');
        Route::post('/', 'ProductController@save');
        Route::put('/', 'ProductController@update');
        Route::delete('/{id}', 'ProductController@delete');
    });
    
    Route::resource('user', 'UserController');
});
