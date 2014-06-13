<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 13.06.14
 * Time: 15:55
 */

class Vote extends Eloquent{
    protected $table = "votes";
    protected $guarded = array();
    public function Skin()
    {
        return $this->belongsTo("Skin");
    }
    public function User()
    {
        return $this->belongsTo("User");
    }
}