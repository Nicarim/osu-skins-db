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
        Route::group(array("before" => "auth"), function(){
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
        Route::get('/list/{sorting?}', array(
                "uses" => "SkinsController@listOfSkins",
                "as" => "SkinListing"
            ));
        Route::get('/view/{id}/{section?}', array(
                "uses" => "SkinsController@viewSkin",
                "as" => "SkinIndex"
            ));
        Route::get("/download/{id}", array(
                "uses" => "SkinsController@downloadSkin",
                "as" => "SkinDownload"
            ));
        Route::post('/upload-element/{id}', array(
                "uses" => "SkinsController@saveElement"
            ));
        Route::get('/delete-element/{id}', array(
                "uses" => "SkinsController@deleteElement"
            ));
    });

Route::group(array("prefix" => "previews", "before" => "auth"), function(){
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
                "before" => "guest",
                "uses" => "LoginController@loginOAuth",
                "as" => "login"
            ));
        Route::get("/logout", array(
                "before" => "auth",
                "uses" => "LoginController@logoutOAuth",
                "as" => "logout"
            ));
        Route::get('/own/skins', array(
                "before" => "auth",
                "uses" => "SkinsController@ownListOfSkins",
                "as" => "ownSkins"
            ));
    });


