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
} 