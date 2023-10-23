<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
 
Route::get('/sync', ['uses' => 'App\Http\Controllers\SyncController@index'])->name('sync');

Route::name('front.')->group(function(){   
    Route::match(['get', 'post'], '/', ['uses' => 'App\Http\Controllers\HomeController@in'])->name('home'); 
    Route::match(['get', 'post'], '/admin', ['uses' => 'App\Http\Controllers\AdminController@index'])->name('admin'); 
});

//Route::name('api.')->group(function(){Route::match(['get', 'post'], '/api/stoimost', ['uses' => 'App\Http\Controllers\ApiController@stoimost'])->name('stoimost');});