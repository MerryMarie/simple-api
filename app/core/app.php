<?php
class App{

    private static function loadModule($sModuleName){
       try{
           if(class_exists($sModuleName)){
           
                return true;
            }else{
                throw new Exception("There is no such module");
            }
           // include  Mod::getDirRoot() . '/core/api/v1/controller.php';
       }catch(Throwable $exception){
           //require_once(Mod::getDirRoot().'/core/modules/error/404.php');
           echo $exception;
           return false;
       }

    }
    private static function runModule($sModuleName='v1'){
        $cntr=ucfirst($sModuleName).'_Controller';
        //Logger::log(explode("_",$cntr));
        if(self::loadModule($cntr)){
        $act='run_'.Request::$route->action;
            if(method_exists($cntr,$act)) {
                $cntr::$act();
            }else{
                
                $cntr::run_404();
            }
        }
    }
    public static function run(){
      //  trigger_error("Cannot divide by zero", E_USER_ERROR);
        $mod=Request::$route->module;
        self::runModule($mod);

    }
}