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
Route::group(array("prefix" => "skins"), function(){
        Route::get('/list/{sorting?}', array(
                "uses" => "SkinsController@listOfSkins",
                "as" => "SkinListing"
            ));
        Route::get('/view/{id}/{section?}', array(
                "uses" => "SkinsController@viewSkin",
                "as" => "SkinIndex"
            ));
        Route::post('/settings/{id}/{section}', array(
                "uses" => "SkinsController@editSettings",
                "as" => "SkinSettings"
            ));
        Route::get('/create', function(){
                return View::make('create');
            });
        Route::post('/create', array(
                "uses" => "SkinsController@createSkin"
            ));
    });

Route::group(array("prefix" => "previews"), function(){
        Route::get('/manage', array(
                "uses" => "PreviewsController@viewSettings",
                "as" => "PreviewsManage"
            ));
        Route::post('/create',array(
                "uses" => "PreviewsController@createPreview",
                "as" => "CreatePreview"
            ));
    });
Route::group(array("prefix" => "users"), function(){
        Route::get("/login", array(
                "uses" => "LoginController@loginOAuth",
                "as" => "login"
            ));
        Route::get("/logout", array(
                "uses" => "LoginController@logoutOAuth",
                "as" => "logout"
            ));
    });


