<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',array(
        "uses" => "SkinsController@index",
        "as" => "Home"
    ));
Route::get('/skins/list/{sorting?}', array(
        "uses" => "SkinsController@listOfSkins",
        "as" => "SkinListing"
    ));
Route::get('/skins/view/{id}/{section?}', array(
        "uses" => "SkinsController@viewSkin",
        "as" => "SkinIndex"
    ));
Route::post('/skins/settings/{id}/{section}', array(
        "uses" => "SkinsController@editSettings",
        "as" => "SkinSettings"
    ));
Route::get('/skins/create', function(){
    return View::make('create');
});
Route::post('/skins/create', array(
        "uses" => "SkinsController@createSkin"
    ));
Route::post('/file-upload/{id}', array(
   "uses" => "SkinsController@saveElement"
));
Route::get('/file-delete/{id}', array(
   "uses" => "SkinsController@deleteElement"
));