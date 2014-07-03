<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 06.03.14
 * Time: 19:11
 */

class SkinElement extends Eloquent {
    protected $table = "skins_elements";
    protected $guarded = array();
    public function skin(){
        return $this->belongsTo("Skin");
    }
    public function getFullname(){
        $ishd = $this->ishd == 1 ? "@2x." : ".";
        $isSequence = $this->sequence_frame != -1 ? $this->sequence_frame : "";
        return $this->filename.$isSequence.$ishd.$this->extension;
    }
    public function getName(){
        $isSequence = $this->sequence_frame != -1 ? $this->sequence_frame : "";
        $ishd = $this->ishd == 1 ? "@2x" : "";
        return $this->filename.$isSequence.$ishd;
    }
    public function getVisibleName(){
        $name = $this->sequence_frame != -1 ? substr($this->filename, 0, -1) : $this->filename;
        $ishd = $this->ishd == 1 ? "@2x" : "";
        return $name.$ishd;
    }
    public function group(){
        return $this->belongsTo("Group");
    }
    public function isAudio(){
        return in_array($this->extension, array("mp3","ogg","wav"));
    }
    public function isImage(){
        return in_array($this->extension, array("jpg","jpeg","png"));
    }
    public function isConfig(){
        return in_array($this->extension, array("txt", "ini"));
    }
    public function isAnimation(){
        return $this->issequence == 1;
    }
    public function className(){
        $ishd = $this->ishd == 1 ? "2x" : "";
        return $this->filename.$ishd;
    }
    public function getClasses($asGroup = true, $openFancybox = true){
        $string = "";
        $string .= $this->isAudio() ? ' audio-element ' : '';
        $string .= $this->isConfig() ? 'config-element ' : '';
        if (!$asGroup)
            $string .= $this->isAnimation() ? 'animatable-element ' : '';
        else
            $string .= $this->isAnimation() ? 'animatable-group' : '';
        
        if ($openFancybox)
            $string .= $this->isImage() ? 'fancybox ' : '';
        return $string;
    }
} 