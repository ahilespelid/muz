<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
 
Route::get('/sync', ['uses' => 'App\Http\Controllers\SyncController@index'])->name('sync');
Route::post('/reset', ['uses' => 'App\Http\Controllers\HomeController@reset'])->name('reset');


Route::name('front.')->group(function(){   
    Route::match(['get', 'post'], '/', ['uses' => 'App\Http\Controllers\HomeController@index'])->name('home'); 
    Route::match(['get', 'post'], '/admin', ['uses' => 'App\Http\Controllers\AdminController@index'])->name('admin'); 
    Route::match(['get', 'post'], '/widget', ['uses' => 'App\Http\Controllers\HomeController@widget'])->name('widget'); 
});

//Route::name('api.')->group(function(){Route::match(['get', 'post'], '/api/stoimost', ['uses' => 'App\Http\Controllers\ApiController@stoimost'])->name('stoimost');});