<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:59
 */

class SkinsController extends BaseController{
    function index(){
        return View::make('index')->with("google", json_decode(OAuth::consumer("google")->request("https://www.googleapis.com/oauth2/v1/userinfo"), true));
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
        $uploadedElements = array();
        $skin = Skin::find($id);
        $data = Input::all();
        $rules = array(
            'file' => 'mimes:jpeg,bmp,png,mp3,wav,ogg'
        );
        $validation = Validator::make($data, $rules);

        if ($validation->fails())
            return Response::make($validation->errors->first(), 400);

        $filename = $data['file']->getClientOriginalName();
        if ($skin->hdsupport == 1)
        {
            $hdfilename = explode(".",$filename)[0]."@2.".$data['file']->getClientOriginalExtension();
            $uploadedElements[] = SkinElement::firstOrCreate(array(
                "skin_id" => $skin->id,
                "filename" => $hdfilename,
                "extension" => $data['file']->getClientOriginalExtension(),
                "element_id" => -2, //-2 is supposed to mean that it should be skipped from checking (hd elements)
                "highdef" => 1,
                "hashd" => 1,
                "size" => $data['file']->getSize()
            ));
            $uploadedElements[] = SkinElement::firstOrCreate(array( //non HD element
                "skin_id" => $skin->id,
                "filename" => $filename,
                "extension" => $data['file']->getClientOriginalExtension(),
                "element_id" => -1, //TODO: make this check for existence in database of default skin
                "highdef" => 0,
                "hashd" => 1,
                "size" => $data['file']->getSize()
            ));
            $data['file']->move(public_path()."/skins-content/".$skin->id, $hdfilename);
            $imageToResize = Image::make(public_path()."/skins-content/".$skin->id."/".$hdfilename);
            $imageToResize->resize($imageToResize->width / 2, null, true);
            $imageToResize->save(public_path()."/skins-content/".$skin->id."/".$filename);
        }
        else
        {
            $uploadedElements[] = SkinElement::firstOrCreate(array(
                "skin_id" => $skin->id,
                "filename" => $filename,
                "extension" => $data['file']->getClientOriginalExtension(),
                "element_id" => -1, //TODO: make this check for existence in database of default skin
                "highdef" => 0,
                "hashd" => 0,
                "size" => $data['file']->getSize()
            ));
            $data['file']->move(public_path()."/skins-content/".$skin->id, $filename);
        }

        if ($filename == "go.png" || $filename == "count1.png" || $filename == "count2.png" || $filename == "count3.png") //generate image based on existence in any dynamic image
            $this->generateImage();
        return View::make('skin-sections/table-row')->with(array(
            'elements' => $uploadedElements
        ));
    }
    function deleteElement($id){
        $element = SkinElement::find($id);
        if (isset($element))
        {
            File::delete(public_path()."/skins-content/".$element->skin->id."/".$element->filename);
            $element->delete();
            return Response::json('success');
        }
        else
            return Response::json('fail');

    }
    function generateImage(){
        $image = Image::make(public_path().'/preview.jpg');
        $image->colorize(-100,-100,-100);
        $goimg = SkinElement::where('filename','=','go.png')->first();
        $pathgoimg = public_path().'/skins-content/'.$goimg->skin->id.'/'.$goimg->filename;
        $pathcount1 = public_path().'/skins-content/1/count1.png';
        $pathcount2 = public_path().'/skins-content/1/count2.png';
        $pathcount3 = public_path().'/skins-content/1/count3.png';
        $image->insert($pathcount1,0,0,'middle-left');
        $image->insert($pathcount2,0,0,'top');
        $image->insert($pathcount3,0,0,'middle-right');
        $image->insert($pathgoimg,0,0,'bottom');
        try
        {
            $image->save(public_path().'/previews-content/'.$goimg->skin->id.'/countdown.jpg');
        }
        catch (Intervention\Image\Exception\ImageNotWritableException $e)
        {
            try
            {
                mkdir("previews-content/".$goimg->skin->id.'/');
            }
            catch(Exception $e2)
            {

            }
            $image->save(public_path().'/previews-content/'.$goimg->skin->id.'/countdown.jpg');
        }
        $image->resize(340,null,true);
        $image->save(public_path().'/previews-content/'.$goimg->skin->id.'/countdown-preview.jpg');
        return Response::make($image, 200, array('Content-Type' => 'image/jpeg'));
    }
} 