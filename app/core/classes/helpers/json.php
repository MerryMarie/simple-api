<?php
namespace Helpers;
class Json{
    public static function encode($array){
        return json_encode($array);
    }
    public static function decode($json_str){
        return json_decode($json_str,true);
    }
}
