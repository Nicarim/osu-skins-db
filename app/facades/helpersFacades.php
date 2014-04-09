<?php
use Illuminate\Support\Facades\Facade;

class helpersFacades extends Facade{
    protected static function getFacadeAccessor() { return 'helpers'; }
}