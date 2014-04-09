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
        return $this->filename.$ishd.$this->extension;
    }
} 