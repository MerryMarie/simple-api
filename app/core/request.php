<?php
class Request  /*extends  HttpRequest*/{
    public static $method=null;//static 
    public static $uri=null;
    public static $route=null;
    public static $params=null;
    public static $user=null;
    public  static $refferer=null;
    /*public function __construct(){

    }**/
    public static function init(){
        //обработка запроса
        self::$method=strtolower($_SERVER['REQUEST_METHOD']);//GET,POST,PUT,DELETEs
        self::$uri= $_SERVER['REQUEST_URI'];
        self::$route=self::getRoute(self::$uri);
        self::$user=User::init();
        self::$refferer=$_SERVER['HTTP_REFERER']??null;
    }
    public static function getRoute($uri){
        return Route::route($uri);
    }
    public static function get($key){
        return $_GET[$key]??null;
    }
    
    public static function post($key){
        return $_POST[$key]??null;
    }
    public static function cookie($key){
        return $_COOKIE[$key]??false;
    }
    public static function redirect($path="/"){
       header("Location: {$path}");
       die();
    }
    
}