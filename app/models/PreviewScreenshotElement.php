<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 07.03.14
 * Time: 19:32
 */

class PreviewScreenshotElement extends Eloquent{
    protected $table = "preview_screenshot_elements";
    protected $guarded = array();
    public function PreviewScreenshot(){
        return $this->belongsTo("PreviewScreenshot");
    }
} 