<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 08.03.14
 * Time: 11:47
 */

class PreviewsController extends BaseController {
    public function viewSettings(){
        $previews = PreviewScreenshot::all();
        return View::make('previews-manage')->with(array(
                "previews" => $previews
            ));
    }
    public function createPreview(){
        $data = Input::all();
        $preview = new PreviewScreenshot;
        $preview->name = $data['screenshot-name'];
        $preview->save();
        return Redirect::back();
    }

} 