<?php
class Model{
    public static function init(){
    }
    public static function run($method,$params=null){
        if(method_exists(get_called_class() ,$method)){
            static::$method($params);
       }
       else{
           throw new Exception("There is no such method in class ".get_called_class() );
           
       }
    }
}