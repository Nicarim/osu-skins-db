<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:40
 */

class Skin extends Eloquent {
    protected $table = 'skins';
    protected $guarded = array();
    public function SkinElement(){
        return $this->hasMany("SkinElement")->orderBy('filename','asc');
    }
} 