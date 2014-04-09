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
        return Response::download($zipname);

    }
    function saveElement($id){
        $uploadedElements = array();
        $skin = Skin::find($id);
        $data = Input::all();
        if ($skin->user_id != Auth::user()->id)
            throw new AccessDeniedException;
        $rules = array(
            'file' => 'mimes:jpeg,png,mp3,wav,ogg'
        );
        $validation = Validator::make($data, $rules);

        if ($validation->fails())
            return Response::make($validation->errors->first(), 400);

        $filename = array(
            "fullname" => $data['file']->getClientOriginalName(),
            "filename" => rtrim(basename($data['file']->getClientOriginalName(), $data['file']->getClientOriginalExtension()),"."),
            "extension" => $data['file']->getClientOriginalExtension()
        );
        if (in_array($filename['extension'], array("jpg","jpeg","png")))
        {
            if ($skin->hdsupport == 1)
            {
                $hdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 1,
                    ));
                $hdSkinElement->element_id = -2;
                $hdSkinElement->size = $data['file']->getSize();
                $data['file']->move(public_path()."/skins-content/".$skin->id, $hdSkinElement->filename."@2.".$hdSkinElement->extension);
                $hdSkinElement->save();
                $uploadedElements[] = $hdSkinElement;
                $sdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 0
                    ));
                $sdSkinElement->element_id = -1;
                $imageToResize = Image::make(public_path()."/skins-content/".$skin->id."/".$hdSkinElement->filename."@2.".$hdSkinElement->extension);
                $imageToResize->resize($imageToResize->width / 2, null, true);
                $imageToResize->save(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                $sdSkinElement->size = filesize(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                $sdSkinElement->save();
                $uploadedElements[] = $sdSkinElement;
            }
            else
            {
                $SkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 0
                    ));
                $SkinElement->element_id = -1;
                $SkinElement->size = $data['file']->getSize();
                $SkinElement->save();
                $uploadedElements[] = $SkinElement;
                $data['file']->move(public_path()."/skins-content/".$skin->id, $filename['fullname']);
            }
        }
        else
        {
            $SkinElement = SkinElement::firstOrNew(array(
                    "skin_id" => $skin->id,
                    "filename" => $filename['filename'],
                    "extension" => $filename['extension'],
                    "ishd" => 0
                ));
            $SkinElement->element_id = -1;
            $SkinElement->size = $data['file']->getSize();
            $SkinElement->save();
            $uploadedElements[] = $SkinElement;
            $data['file']->move(public_path()."/skins-content/".$skin->id, $filename['fullname']);
        }

        /*if ($filename == "go.png" || $filename == "count1.png" || $filename == "count2.png" || $filename == "count3.png") //generate image based on existence in any dynamic image
            $this->generateImage();*/
        return View::make('skin-sections/table-row')->with(array(
            'elements' => $uploadedElements
        ));
    }
    function deleteElement($id){
        $element = SkinElement::find($id);
        if (Auth::user()->id != $element->skin->user_id)
            throw new AccessDeniedException;
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