<?php
class V2_Model extends Model{

    public static function run_index(){
        Response::sendJSON(array("data"=>["app_name"=>"FireNote"],'status'=>200,'error'=>''));
    }
    public static function  run_countries(){
        if(!empty(Request::$route->params[0])){
            self::run(Request::$method.'_'.Request::$route->action.'_'.Request::$route->params[0]);
        }
    }
    public static function  run_user(){
        if(!empty(Request::$route->params[0])){
            self::run(Request::$method.'_'.Request::$route->action.'_'.Request::$route->params[0]);
        }
    }
    protected static  function get_user_check(){
        
        if(Request::$user->isAuthorised()){
            $usr=Request::$user->getUserInfo();
            Response::sendJSON([array("username"=>$usr["login"],"auth"=>"true",'status'=>200,'error'=>'')]);
        }else{
            Response::sendJSON([array("auth"=>"false",'status'=>403,'error'=>'')]);
        }
    }
    protected static  function get_countries_list(){
        $arr=DataStorageController::getList();
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: http://localhost:8080");
        header("Access-Control-Allow-Headers: *");
        Response::sendJSON($arr);
    }
    public static function  run_register($data){
        $usr=DB::existUser($data[0]);
        if(!$usr){
            $id=DB::addUser($data[0],md5($data[1]));
            if($id){
            $atok=md5(time().uniqid());
            DB::setSess($id,$atok);
            Response::sendJSONAuth(array("data"=>["Answer"=>"Successful register"],'status'=>200,'error'=>''),$atok);
        }
        else{
            Response::sendJSON(array("data"=>array("Answer"=>"Register failed","d"=>$data[0]),'status'=>400,'error'=>''));
        }
 
    }
    }
    public static function  run_logout(){
        $cookie=Request::cookie('auth_token');
        if( $cookie){
            DB::unsetSess($cookie);
            
        }    
        Response::sendJSONAuth(array('status'=>200,'error'=>''),"");
    }
    public static function  run_login($data){
        if($data[0]&& $data[1]){
            
            //db request, for example
            $usr=DB::checkCreds($data[0],md5($data[1]));
            if($usr){//$data[0]=='Mary1234' && $data[1]=='0987'
           // $u=Request::$user->getUserInfo();
            $atok=md5(time().uniqid());
            DB::setSess($usr['id'],$atok);
            Response::sendJSONAuth(array("username"=>$usr['login'],'status'=>200,'error'=>''),$atok);
            }
            else{
                Response::sendJSON(array("username"=>"",'status'=>400,'error'=>''));
            }
        }else{
            Response::sendJSON(array("username"=>"",'status'=>403,'error'=>''));
        }
    }
}