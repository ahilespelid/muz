<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::name('front.')->group(function(){   
Route::match(['get', 'post'], '/', ['uses' => 'App\Http\Controllers\HomeController@index'])->name('home');    
Route::match(['get', 'post'], '/save', ['uses' => 'App\Http\Controllers\HomeController@save'])->name('save');    
  
});

//Route::name('api.')->group(function(){Route::match(['get', 'post'], '/api/stoimost', ['uses' => 'App\Http\Controllers\ApiController@stoimost'])->name('stoimost');});