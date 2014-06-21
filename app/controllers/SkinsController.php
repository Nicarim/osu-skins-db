<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:59
 */

class SkinsController extends BaseController{
    function index(){
        return Redirect::to("/skins/list");
    }
    function listOfSkins($sorting=null){
        $skins = null;
        $isSorted = false;
        $numberOfResults = 12;
        $currentPage = Input::has("p") ? Input::get("p") : 1;
        $skipped = ($currentPage - 1) * $numberOfResults;
        if ($sorting != null)
        {
            switch($sorting)
            {
                case "rating":
                    $skins = Skin::orderBy("votes", "desc");
                    break;
                case "downloads":
                    $skins = Skin::orderBy("download_count", "desc");
                    break;
                default:
                    $isSorted = true;
                    break;
            }
        }
        else
            $isSorted = true;

        if ($isSorted)
            $skins = Skin::skip($skipped)->take($numberOfResults);
        else
            $skins->skip($skipped)->take($numberOfResults);

        $skins = $skins->get();
        return View::make('listing')->with(array(
                "skins" => $skins,
                "private" => false,
                "canShowMore" => $skins->count() >= 12
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
        $skin->load('SkinElement');
        if (isset($skin)){
            $array = array();
            $array['skin'] = $skin;
            if (Auth::check() && Auth::user()->id != $skin->user_id)
                $array['vote'] = Vote::where("skin_id", $id)->where("user_id", Auth::user()->id)->first();

            $skin->template != 1 ?: $array['groups'] = Group::all();

            return View::make('view-skin')->with($array);
        }
        else
            return Redirect::route('Home');
    }
    function starSkin($id)
    {
        $skin = Skin::find($id);
        $star = Vote::firstOrNew(array(
               "user_id" => Auth::user()->id,
               "skin_id" => $id
            ));
        $userstar = Vote::where("user_id", Auth::user()->id)->where("skin_id", $id)->first();
        if (isset($userstar))
        {
            $userstar->delete();
            $skin->votes -= 1;
        }
        else
        {
            $skin->votes += 1;
            $star->save();
        }
        $skin->save();
        return Response::json("success");
    }
    function editSettings($id){
        $data = Input::all();
        $skin = Skin::find($id);
        $skin->description = $data['description'];
        $skin->name = $data['title'];
        if (isset($data['warnnsfw']))
            $skin->nsfw = 1;
        else
            $skin->nsfw = 0;
        if (Input::hasFile("thumbnail"))
        {
            $skin->thumbnail = 1;
            $skin->save();
            $path = public_path()."/previews-content/".$skin->id."/";
            $this->processThumbnail(Input::file("thumbnail"), $path);
        }
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
        $previewRoot = 'previews-content/'.$skin->id.'/';
        if (!is_dir($previewRoot))
            mkdir($previewRoot);

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
        if (Input::hasFile("thumbnail"))
        {
            $skin->thumbnail = 1;
            $skin->save();
            $path = public_path()."/".$previewRoot;
            $this->processThumbnail(Input::file("thumbnail"), $path);
        }
        return Redirect::to('/skins/view/'.$skin->id);
    }
    function processThumbnail($file, $path)
    {
        $file->move($path, "thumbnail.png");
        $imageToResize = Image::make($path."thumbnail.png");
        $imageToResize->resize(200, null, function($constraint){
                $constraint->aspectRatio();
            });
        $imageToResize->save($path."thumbnails.png");
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
    private function processElement($skin, $file)
    {
        $processedElements = array();
        $oldanimationRegex = "/sliderb\d|pippidonclear\d|pippidonfail\d|pippidonidle\d|pippidonkiai\d/";
        $rules = array(
            'file' => 'mimes:jpeg,png,mp3,wav,ogg,txt'
        );
        $validation = Validator::make(array("file" => $file), $rules);
        if ($validation->fails())
            return "error";
        //processing of skin metadata
        $elementName = strtolower($file->getClientOriginalName());
        $elementExt = strtolower($file->getClientOriginalExtension());
        $filename = array(
            "fullname" => $elementName,
            "filename" => rtrim(basename($elementName, $elementExt),"."),
            "fullnameUntouched" => $elementName,
            "extension" => $elementExt,
            "ishd" => strpos($elementName, "@2x"),
            "shouldScaleDown" => true,
            "hashdcounterpart" => false
        );
        $sizeDifference = 0;
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
        $DBskinElements = SkinElement::where("filename", "=", $filename['filename'])->where("skin_id", "=", $skin->id)->get();

        if (isset($DBskinElements))
        {
            foreach($DBskinElements as $DBskinElement)
            {
                if ($DBskinElement->ishd == 0 && $DBskinElement->useroverriden == 1)
                    $filename['shouldScaleDown'] = false;
                if ($DBskinElement->ishd == 1)
                    $filename['hashdcountepart'] = true;
            }
        }
        $elementGroup = Element::where('element_name', '=', $filename['filename'])->first();
        if (in_array($filename['extension'], array("jpg","jpeg","png")))
        {
            if ($filename["ishd"] && $filename['shouldScaleDown'])
            {
                $hdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 1,
                        "sequence_frame" => $filename['frame'],
                    ));
                $hdSkinElement->group_id = isset($elementGroup) ? $elementGroup->group_id : -1;

                if ($hdSkinElement->exists)
                    $sizeDifference += $hdSkinElement->size;

                $hdSkinElement->size = $file->getSize();
                $file->move(public_path()."/skins-content/".$skin->id, $hdSkinElement->getFullname());
                if ($filename['issequence'])
                {
                    $hdSkinElement->issequence = 1;
                    $hdSkinElement->sequence_frame = $filename['frame'];
                }
                $hdSkinElement->save();
                $processedElements[] = $hdSkinElement;

                $sdSkinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => 0,
                        "sequence_frame" => $filename['frame'],
                    ));
                $sdSkinElement->group_id = isset($elementGroup) ? $elementGroup->group_id : -1;

                $imageToResize = Image::make(public_path()."/skins-content/".$skin->id."/".$hdSkinElement->getFullname());
                $imageToResize->resize(ceil(floatval($imageToResize->width() / 2)), ceil(floatval($imageToResize->height() / 2)));
                $imageToResize->save(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                if ($sdSkinElement->exists)
                    $sizeDifference += $sdSkinElement->size;

                $sdSkinElement->size = filesize(public_path()."/skins-content/".$skin->id."/".$filename['fullname']);
                if ($filename['issequence'])
                {
                    $sdSkinElement->issequence = 1;
                    $sdSkinElement->sequence_frame = $filename['frame'];
                }
                $sdSkinElement->save();
                $processedElements[] = $sdSkinElement;
            }
            else
            {
                $skinElement = SkinElement::firstOrNew(array(
                        "skin_id" => $skin->id,
                        "filename" => $filename['filename'],
                        "extension" => $filename['extension'],
                        "ishd" => $filename['ishd'] ? 1 : 0,
                        "sequence_frame" => $filename['frame'],
                    ));
                $skinElement->group_id = isset($elementGroup) ? $elementGroup->group_id : -1;
                if ($skinElement->exists)
                    $sizeDifference += $skinElement->size;
                $skinElement->size = $file->getSize();
                if ($filename['issequence'])
                {
                    $skinElement->issequence = 1;
                    $skinElement->sequence_frame = $filename['frame'];
                }
                if (($skinElement->exists || !$filename['hashdcounterpart']) && $skinElement->ishd != 1)
                    $skinElement->useroverriden = 1;
                $skinElement->save();
                $processedElements[] = $skinElement;
                $file->move(public_path()."/skins-content/".$skin->id, $filename['fullnameUntouched']);
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
            $skinElement->element_id = isset($elementGroup) ? $elementGroup->group_id : -1;

            if ($skinElement->exists)
                $sizeDifference += $skinElement->size;
            $skinElement->size = $file->getSize();
            $skinElement->save();
            $processedElements[] = $skinElement;
            $file->move(public_path()."/skins-content/".$skin->id, $filename['fullnameUntouched']);
        }

        $elementsSize = 0;
        foreach($processedElements as $element)
            $elementsSize += $element->size;

        if ($sizeDifference != 0)
        {
            $diff = $sizeDifference - $elementsSize;
            $skin->size += $diff;
        }
        else
            $skin->size += $elementsSize;
        $skin->save();
        return $processedElements;
    }
    function saveElement($id){
        $uploadedElements = array();
        $skin = Skin::find($id);
        $data = Input::file();
        if ($skin->user_id != Auth::user()->id)
            throw new AccessDeniedException;

        foreach($data['file'] as $file)
        {
            $response = $this->processElement($skin, $file);
            if ($response != "error")
                $uploadedElements = array_merge($uploadedElements, (array)$response);
            else
                return Response::make("Invalid file extension", 400);
        }

        //add skin size
        /*foreach($uploadedElements as $elementSize)
            $skin->size += $elementSize->size;*/
        /*if ($filename == "go.png" || $filename == "count1.png" || $filename == "count2.png" || $filename == "count3.png") //generate image based on existence in any dynamic image
            $this->generateImage();*/
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
            $skin->save();
            $element->delete();
            return Response::json('success');
        }
        else
            return Response::json('fail');

    }
    function getMissingElements($id, $group=null){
        $compareArray = array();
        $groupModel = null;
        if ($group == null){
            $groupModel = Element::all();
        }
        else{
            $groupModel = Group::find($group)->element;
        }
        $skinElementModel = SkinElement::where('skin_id', '=', $id)->get();
        foreach($groupModel as $model){
            $flagFound = false;
            foreach($skinElementModel as $elementModel){
                if ($model->element_name == $elementModel->filename)
                {
                    $flagFound = true;
                    break;
                }
            }
            if (!$flagFound)
                $compareArray[] = $model->skinelement;
        }
        return View::make('skin-sections/table-row')->with(array(
                "elements" => $compareArray,
                "missing" => true
            ));

    }
    function addElementToGroup(){
        if (Auth::check() && Auth::user()->topaccess == 1)
        {
            $array = Input::get("selectedItems");
            $group_id = Input::get("group_id");
            foreach ($array as $itemId)
            {
                $skinElement = SkinElement::find($itemId);
                $element = Element::firstOrNew(array(
                       "group_id" => $group_id,
                       "skin_element_id" => $skinElement->id,
                       "element_name" => $skinElement->filename
                    ));
                $element->save();
                $elementsToRefresh = SkinElement::where('filename', '=', $element->element_name)->get();
                foreach($elementsToRefresh as $refresh)
                {
                    $refresh->group_id = $element->group_id;
                    $refresh->save();
                }
            }
        }
        return Redirect::back();
    }
    function addGroup(){
        if (Auth::check() && Auth::user()->topaccess == 1)
        {
            $group = new Group;
            $group->name = Input::get("groupName");
            $group->save();
        }
        return Redirect::back();
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