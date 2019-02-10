<?php


Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/{page?}', 'MtaaController@pwa')->name('pwa');

Route::get('/api/{endpoint}', 'ApiController@handle')->name('getapi');
Route::post('/api/{endpoint}', 'ApiController@handle')->name('postapi');

Route::get('/admin/{endpoint}', 'AdminController@handle')->name('getadmin');
Route::post('/admin/{endpoint}', 'AdminController@handle')->name('postadmin');


Route::group(['middleware' => 'cors'], function() {
   Route::post('/web-api/{endpoint}', 'ApiController@handle');

});