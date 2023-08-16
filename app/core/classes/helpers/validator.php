<?php
namespace Helpers;
class Validator{
    public static function isValidLogin($sLogin){
        if(strlen($sLogin)>=5){
            return true;
        }
        return false;
    }
}