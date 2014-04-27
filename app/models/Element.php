<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:40
 */

class Element extends Eloquent {
    protected $table = 'elements';
    protected $guarded = array();
    public function Group(){
        return $this->belongsTo("Group");
    }
    public function SkinElement(){
        return $this->hasOne("SkinElement");
    }
} 