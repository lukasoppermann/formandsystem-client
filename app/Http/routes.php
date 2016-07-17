<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function(){
    return redirect('/home');
});
Route::post('/bust-cache', function(\Illuminate\Http\Request $request){
    if($request->json('code') === env('API_CACHE_SECRET')){
        \Log::debug('Kill cache');
    }
});

Route::get('/{page?}/{sublink?}', 'Pages@show');
