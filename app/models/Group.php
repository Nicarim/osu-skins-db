<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:40
 */

class Group extends Eloquent {
    protected $table = 'groups';
    protected $guarded = array();
    public function Element(){
        return $this->hasMany("Element");
    }
} 