<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 07.03.14
 * Time: 19:32
 */

class PreviewScreenshot extends Eloquent {
    protected $table = "preview_screenshots";
    protected $guarded = array();
    public function previewscreenshotelements(){
        return $this->hasMany('PreviewScreenshotElement');
    }
} 