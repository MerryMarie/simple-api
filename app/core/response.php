<?php
use Helpers\Json as JS;
class Response{
    private static $status=400;
    private static $errors='';
    private  static $data=[];
    private static $aHeaders=[
        "Content-Type: application/json; charset=UTF-8",
        "Access-Control-Allow-Origin: http://localhost:8080",
        "Access-Control-Allow-Headers: *",
        "Access-Control-Allow-Credentials: true",
    ];
    private static function setHeaders(){
        $h=self::$aHeaders;
        foreach($h as $sHeader){
            header($sHeader);
        }
    }
    public static function sendJSON($aResp){
        self::setHeaders();
        die( JS::encode($aResp));
    }
    public static function sendJSONAuth($aResp,$sToken){
        self::setHeaders();
        header("Set-Cookie: auth_token={$sToken};Secure;path=/; HttpOnly;SameSite=none");
       
        die( JS::encode($aResp));
    }
    public static function send(){
        self::setHeaders();
       
        die( JS::encode(self::getResponse()));
    }
    public static function setCookie($aName,$aValue,$sPath="/",$bHttpOnly=true){
        self::addHeader("Set-Cookie: {$aName}={$aValue};Secure;path={$sPath}; ".($bHttpOnly?"HttpOnly":"").";SameSite=none");
    }
    public static function addHeader($sHeader){
        self::$aHeaders[]=$sHeader;
    }
    private static function getResponse(){
        $aResponse=array(
            "data"=>self:: $data,
            "status"=>self::$status,
            "error"=>self::$errors
        );
        return $aResponse;
    }
    public static function setStatus($iStatus){
        self::$status=$iStatus;
    }
    public static function setError($sError){
        self::$errors=$sError;
    }
    public static function setData($aData){
        self::$data=$aData;
    }
}