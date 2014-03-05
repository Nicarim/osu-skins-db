<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:59
 */

class SkinsController extends BaseController{
    function index(){
        return View::make('index');
    }
    function listOfSkins($sorting=null){
        $skins = Skin::all();
        return View::make('listing')->with(array(
                "skins" => $skins
            ));
    }
    function viewSkin($id, $section=null){
        $skin = Skin::find($id);
        if ($skin->exists){
            return View::make('view-skin')->with(array(
                    "skin" => $skin
                ));
        }
        else
            Redirect::route('Home');
    }
} 