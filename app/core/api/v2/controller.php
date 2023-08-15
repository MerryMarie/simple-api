<?php
class V2_Controller extends Controller{
    public static function  run_index(){
        self::run(__FUNCTION__);
    }
    public static function  run($method,$params=null){
        if(method_exists('V2_Model',$method)){
             V2_Model::$method($params);
        }
        else{
            throw new Exception("There is no such method in class V2_Model");
            
        }
    }
    public static function  run_countries(){
        self::run(__FUNCTION__);
    }
    public static function  run_user(){
        self::run(__FUNCTION__);
    }
    public static function  run_register(){
        if(Request::post('login') && Request::post('pass')){
        self::run(__FUNCTION__,[Request::post('login'),Request::post('pass')]);
        }else{
            self::run(__FUNCTION__);}
    }
    public static function  run_logout(){
        self::run(__FUNCTION__);
 
    }
    public static function  run_login(){
       
            self::run(__FUNCTION__,[Request::post('login'),Request::post('pass')]);
        
    }
   
    





}