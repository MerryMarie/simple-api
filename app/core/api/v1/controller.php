<?php
class V1_Controller extends Controller{
    public static function  run_index(){
        self::run(__FUNCTION__);
    }
    public static function  run_data(){
        if(Request::post('login') && Request::post('pass')){
            self::run(__FUNCTION__.'__check_user',[Request::post('login'),Request::post('pass')]);
        }else{
        self::run(__FUNCTION__);}
    }
    public static function  run_event(){
        self::run(__FUNCTION__);

    }
    public static function  run_suggestions(){
       // self::run(__FUNCTION__,Mod::getVar('uri')[3]);Ї
       self::run(__FUNCTION__,Request::get('q'));

    }
    public static function  run($method,$params=null){
        if(method_exists('V1_Model',$method)){
             V1_Model::$method($params);
        }
        else{
            throw new Exception("There is no such method in class V1_Model");
            
        }
    }
    public static function  run_logout(){
        self::run(__FUNCTION__);
 
    }
    public static function  run_register(){
        if(Request::post('login') && Request::post('pass')){
        self::run(__FUNCTION__,[Request::post('login'),Request::post('pass')]);
        }else{
            self::run(__FUNCTION__);}
    }


    public static function  run_records(){
        /*if(!Request::$user->isAuthorised()) {
            //Request::redirect('/');
            header("Content-Type: application/json; charset=UTF-8");
             die( json_encode(array("res"=>[],"status"=>"403")));
        }*/
        self::run(__FUNCTION__);
    }





}