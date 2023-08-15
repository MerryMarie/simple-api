<?php
class Log
{
    private static $sFile="";
    public static function log($str){
        $s='['.date("Y-m-d H:i:s").']  '.print_r($str,true).PHP_EOL;
        file_put_contents(self::$sFile,$s,FILE_APPEND);
    }
   public static function setLogFile($path){
        self::$sFile=$path;
   }

}