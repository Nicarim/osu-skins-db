<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 06.03.14
 * Time: 19:11
 */

class SkinElement extends Eloquent {
    protected $table = "skins_elements";
    public function skin(){
        return $this->belongsTo("Skin");
    }
} 