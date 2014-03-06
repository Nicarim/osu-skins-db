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
        if (isset($skin)){
            return View::make('view-skin')->with(array(
                    "skin" => $skin
                ));
        }
        else
            return Redirect::route('Home');
    }
    function editSettings($id, $section){
        $data = Input::all();
        $skin = Skin::find($id);
        $skin->description = $data['description'];

        if (isset($data['warnnsfw']))
            $skin->nsfw = 1;
        else
            $skin->nsfw = 0;

        if (isset($data['hdsupport']))
            $skin->hdsupport = 1;
        else
            $skin->hdsupport = 0;

        $skin->save();
        return Redirect::back();
    }
    function createSkin(){
        $skin = new Skin;
        $data = Input::all();
        if (isset($data['warnnsfw']))
            $skin->nsfw = 1;
        else
            $skin->nsfw = 0;

        if (isset($data['hdsupport']))
            $skin->hdsupport = 1;
        else
            $skin->hdsupport = 0;
        $skin->description = $data['description'];
        $skin->name = $data['title'];
        $skin->save();
        mkdir('skins-content/'.$skin->id.'/');
        return Redirect::to('/skins/view/'.$skin->id);
    }
    function saveElement($id){
        $skin = Skin::find($id);
        $data = Input::all();
        $rules = array(
            "file" => "image"
        );
        $validation = Validator::make($data, $rules);

        if ($validation->fails())
            return Response::make($validation->errors->first(), 400);
        $filename = $data['file']->getClientOriginalName();
        $element = new SkinElement;
        $element->skin_id = $skin->id;
        $element->element_id = -1;
        $element->filename = $filename;
        $element->size = $data['file']->getSize();
        $element->save();

        $data['file']->move(public_path()."/skins-content/".$skin->id, $filename);
        return View::make('skin-sections/table-row')->with(array(
            'element' => $element
        ));
    }
} 