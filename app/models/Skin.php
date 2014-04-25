<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 05.03.14
 * Time: 18:40
 */
use \HTMLPurifier;
use \HTMLPurifier_Config;
use Ciconia\Ciconia;
class Skin extends Eloquent {
    protected $table = 'skins';
    protected $guarded = array();
    public function SkinElement(){
        return $this->hasMany("SkinElement")->orderBy('filename','asc');
    }
    public function User(){
        return $this->belongsTo("User");
    }
    public function parsedDescription(){
        $content = $this->description;
        $parser = new Ciconia();
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $htmltopurify = $parser->render($content);
        return $purifier->purify($htmltopurify);
    }
} 