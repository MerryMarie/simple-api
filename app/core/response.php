<?php
class Response{
    public static function setHeaders(){
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: http://localhost:8080");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Credentials: true");
    }
    public static function sendJSON($aResp){
        self::setHeaders();
        die( Helpers\Json::encode($aResp));
    }
    public static function sendJSONAuth($aResp,$sToken){
        self::setHeaders();
        header("Set-Cookie: auth_token={$sToken};Secure;path=/; HttpOnly;SameSite=none");
       
        die( Helpers\Json::encode($aResp));
    }

}