<?php
class Mod{
    public static $aVars=array();
    public static $rootDir='/';
    public static function setVar($sVarName,$sVarValue){
        self::$aVars[$sVarName]=$sVarValue;
    }
    public static function getVar($sVarName){
        return !empty(self::$aVars[$sVarName])?self::$aVars[$sVarName]:null;
    }

    public static function setDirRoot($dir){
       self::$rootDir=$dir;
    }
    public static function getDirRoot(){
        return self::$rootDir;
    }
    public static function getBlock($path){
        include(self::$rootDir.'/styles/templates/'.$path);
    }
}