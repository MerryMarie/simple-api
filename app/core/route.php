<?php
class Route{
    public $module=null;
    public $action=null;
    public $params=null;
    public $u=null;
    public static $aliases=null;
    private static $sApiVwrsion="v1";


    public function __construct($arr){
        if($arr[0]==='api'){
        $this->module=empty($arr[1]) ?  $this->sApiVwrsion:$arr[1];
        $this->action=empty($arr[2]) ?'index':$arr[2];
        $this->params=empty(array_slice($arr,3)) ? null:array_slice($arr,3);
        }else{
           // throw new Exception("Only API request allowed", 1);
            header("Content-Type: application/json; charset=UTF-8");
            die( json_encode(array("err"=>"Only API request allowed")));
        }
    }
    public static function route($uri){
        $url =  explode('?', $uri)[0];
       // $url=self::getUriIfAlias($url);
        $url=array_slice(explode('/',$url), 1);
        return new Route($url);
    }
    public static function setAlias($uri,$alias){
        self::$aliases[$alias]=$uri;
    }
   /* public static function isAlias($uri){
        $us=array_slice(explode('/',$uri), 1);
        foreach($us as $u){
             $u='/'.$u;
           if(isset(self::$aliases[$u])){
            return true;
           }   
        }


        return isset(self::$aliases[$uri]) ? true: false;
    }*/
    public static function getUriIfAlias($uri){
        $url=$uri;
        $us=array_slice(explode('/',$uri), 1);
        foreach($us as $u){
            $u='/'.$u;
            if(!empty(self::$aliases[$u])){
            $url=str_replace($u,self::$aliases[$u], $url);
            }
        }
        return $url;
    }


}