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
                "skins" => $skins,
                "private" => false
            ));
    }
    function ownListOfSkins(){
        $skins = Skin::where("user_id","=",Auth::user()->id)->get();
        return View::make('listing')->with(array(
               "skins" => $skins,
               "private" => true
            ));
    }
    function markAsDefault($id){
        $skin = Skin::find($id);
        if (Auth::user()->topaccess == 1)
            $skin->template = 1;
        $skin->save();
        return Redirect::back();
    }
    function viewSkin($id, $section=null){
        $skin = Skin::find($id);
        if (isset($skin)){
            $array = array();
            $array['skin'] = $skin;
            $skin->template != 1 ?: $array['groups'] = Group::all();
            return View::make('view-skin')->with($array);
        }
        else
            return Redirect::route('Home');
    }
    function editSettings($id){
        $data = Input::all();
        $skin = Skin::find($id);
        $skin->description = $data['description'];

        if (isset($data['warnnsfw']))
            $skin->nsfw = 1;
        else
            $skin->nsfw = 0;

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

        $skin->description = $data['description'];
        $skin->name = $data['title'];
        $skin->user_id = Auth::user()->id;
        $skin->save();
        $skinRoot = 'skins-content/'.$skin->id.'/';
        if (!is_dir($skinRoot))
            mkdir($skinRoot);
        else
        {
            $skinFiles = glob(public_path().'/skins-content/'.$skin->id.'/*');
            foreach($skinFiles as $file)
            {
                if (is_file($file))
                    unlink($file);
            }
        }

        return Redirect::to('/skins/view/'.$skin->id);
    }
    function downloadSkin($id){
        $skin = Skin::find($id);
        if ($skin->SkinElement->count() == 0)
            return "Skin is empty, nothing to download";
        $zip = new ZipArchive();
        $zipname = public_path()."/".$skin->name.".osk";
        $zip->open($zipname, ZipArchive::OVERWRITE);
        $files = glob(public_path()."/skins-content/".$skin->id."/*");
        foreach($files as $file){
            $zip->addFile($file, basename($file));
        }
        $zip->close();


        App::finish(function ($request, $response) use ($zipname){
                unlink($zipname);
            });
        $skin->download_count += 1;
        $skin->save();
        return Response::download($zipname);

    }
    function saveElement($id){
        $uploadedElements = array();
        $skin = Skin::find($id);
        $data = Input::all();
        $oldanimationRegex = "/sliderb\d|pippidonclear\d|pippidonfail\d|pippidonidle\d|pippidonkiai\d/";
        if ($skin->user_id != Auth::user()->id)
            throw new AccessDeniedException;
        //check for extension
        $rules = array(
            'file' => 'mimes:jpeg,png,mp3,wav,ogg'
        );
        $validation = Validator::make($data, $rules);

        if ($validation->fails())
            return Response::make($validation->errors->first(), 400);
        //processing of skin metadata
        $filename = array(
            "fullname" => $data['file']->getClientOriginalName(),
            "filename" => rtrim(basename($data['file']->getClientOriginalName(), $data['file']->getClientOriginalExtension()),"."),
            "fullnameUntouched" => $data['file']->getClientOriginalName(),
            "extension" => $data['file']->getClientOriginalExtension(),
            "ishd" => strpos($data['file']->getClientOriginalName(), "@2x"),
            "shouldScaleDown" => true,
            "hashdcounterpart" => false
        );
        if ($filename['ishd'])
        {
            $filename['filename'] = substr($filename['filename'], 0, -3);
            $filename['fullname'] = $filename['filename'].".".$filename['extension'];
        }
        //pretty complex check if animatable element fits few ... things!
        $filename['issequence'] = (preg_match("/-\d/", $filename['filename']) === 1 ||
                (preg_match("/\d/", $filename['filename']) === 1 && preg_match($oldanimationRegex, $filename['filename']) === 1)) //check for old animatable format
            && preg_match("/score-\d|default-\d/", $filename['filename']) !== 1; // don't mark score digits as animatable elements - they are obviously not.

        if ($filename["issequence"])
        {
            preg_match("/\d+$/", $filename['filename'], $sequenceMatches);
            $filename['frame'] = $sequenceMatches[0];
            $filename['filename'] = substr($filename['filename'], 0, -strlen((string) $filename['frame']));
        }
        else
        {
            $filename['frame'] = -1;
        }
        $DBskinElements = SkinElement::where("filename", "=", $filename['filename'])->get();
        if (isset($DBskinElements))
        {
            foreach($DBskinElements as $DBskinElement)
            {
                //if ($DBskinElement->ishd == 1 && !$filename['ishd'])
                //    $filename['hashdelement'] = true;
                if ($DBskinElement->ishd == 0 && $DBskinElement->useroverriden == 1)
                    $filename['shouldScaleDown'] = false;
                if ($DBskinElement->ishd == 1)
                    $filename['hashdcountepart'] = true;
            }
        }
        /*
        if (isset($DBskinElement) && $DBskinElement->useroverriden == 1)
            $filename['shouldScaleDown'] = false;
        else
            $filename['shouldScaleDown'] = true;*/

        if (in_array($filename['extension'], array("jpg","jpeg","png")))
        {
            if ($filename["ishd"] && $filename['shouldScaleDown'])
            {
                $hdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 1,
                        "sequence_frame" => $filename['frame']
                    ));
                $hdSkinElement->element_id = -2;
                $hdSkinElement->size = $data['file']->getSize();
                $data['file']->move(public_path()."/skins-content/".$skin->id, $hdSkinElement->getFullname());
                if ($filename['issequence'])
                {
                    $hdSkinElement->issequence = 1;
                    $hdSkinElement->sequence_frame = $filename['frame'];
                }
                $hdSkinElement->save();
                $uploadedElements[] = $hdSkinElement;

                $sdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 0,
                        "sequence_frame" => $filename['frame']
                    ));
                $sdSkinElement->element_id = -1;

                $imageToResize = Image::make(public_path()."/skins-content/".$skin->id."/".$hdSkinElement->getFullname());
                $imageToResize->resize(ceil(floatval($imageToResize->width / 2)), null, true);
                $imageToResize->save(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                $sdSkinElement->size = filesize(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                if ($filename['issequence'])
                {
                    $sdSkinElement->issequence = 1;
                    $sdSkinElement->sequence_frame = $filename['frame'];
                }
                $sdSkinElement->save();
                $uploadedElements[] = $sdSkinElement;
            }
            else
            {
                $skinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => $filename['ishd'] ? 1 : 0,
                        "sequence_frame" => $filename['frame']
                    ));
                $skinElement->element_id = -1;
                $skinElement->size = $data['file']->getSize();
                if ($filename['issequence'])
                {
                    $skinElement->issequence = 1;
                    $skinElement->sequence_frame = $filename['frame'];
                }
                if (($skinElement->exists || !$filename['hashdcounterpart']) && $skinElement->ishd != 1)
                    $skinElement->useroverriden = 1;
                $skinElement->save();
                $uploadedElements[] = $skinElement;
                $data['file']->move(public_path()."/skins-content/".$skin->id, $filename['fullnameUntouched']);
            }
        }
        else
        {
            $skinElement = SkinElement::firstOrNew(array(
                    "skin_id" => $skin->id,
                    "filename" => $filename['filename'],
                    "extension" => $filename['extension'],
                    "ishd" => $filename['ishd'] ? 1 : 0
                ));
            $skinElement->element_id = -1;
            $skinElement->size = $data['file']->getSize();
            $skinElement->save();
            $uploadedElements[] = $skinElement;
            $data['file']->move(public_path()."/skins-content/".$skin->id, $filename['fullnameUntouched']);
        }
        //add skin size
        foreach($uploadedElements as $elementSize)
            $skin->size += $elementSize->size;
        /*if ($filename == "go.png" || $filename == "count1.png" || $filename == "count2.png" || $filename == "count3.png") //generate image based on existence in any dynamic image
            $this->generateImage();*/
        $skin->save();
        return View::make('skin-sections/table-row')->with(array(
            'elements' => $uploadedElements
        ));
    }

    function deleteElement($id){
        $element = SkinElement::find($id);
        $skin = Skin::find($element->skin_id);
        if (Auth::user()->id != $element->skin->user_id)
            throw new AccessDeniedException;
        if (isset($element))
        {
            $hdPrefix = $element->ishd == 1 ? "@2x." : ".";
            $filename = $element->filename.$hdPrefix.$element->extension;
            File::delete(public_path()."/skins-content/".$element->skin->id."/".$filename);
            $skin->size -= $element->size;
            $element->delete();
            $skin->save();
            return Response::json('success');
        }
        else
            return Response::json('fail');

    }
    function addElementToGroup(){

    }
    function addGroup(){
        if (Auth::check() && Auth::user()->topaccess == 1)
        {
            $group = new Group;
            $group->name = Input::get("groupName");
            $group->save();
            return Redirect::back();
        }
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