<?php
class V1_Model extends Model{

    public static function run_index(){
        header("Content-Type: application/json; charset=UTF-8");
        die( json_encode(array("name"=>"FireNote")));
    }
    
    public static function  run_data(){
        //db request, for example
        header("Content-Type: application/json; charset=UTF-8");
        die( json_encode(array("name"=>"John Winchester")));
    }
    public static function  run_data__check_user($data){
        //db request, for example
        $usr=DB::checkCreds($data[0],md5($data[1]));
        if($usr){//$data[0]=='Mary1234' && $data[1]=='0987'
        $atok=md5(time().uniqid());
        DB::setSess($usr['id'],$atok);
        header("Content-Type: application/json; charset=UTF-8");
        header("Set-Cookie: auth_token={$atok};Secure;path=/; HttpOnly;SameSite=none");
        //setcookie("auth", '1');
       
        die( json_encode(array("name"=>"Successful auth","code"=>200)));
        }
        else{
            header("Content-Type: application/json; charset=UTF-8");
            die( json_encode(array("name"=>"Auth failed","code"=>0,"d"=>$data[0])));
        }
    }
    public static function  run_register($data){
        $usr=DB::existUser($data[0]);
        if(!$usr){
            $id=DB::addUser($data[0],md5($data[1]));
            if($id){
            $atok=md5(time().uniqid());
            DB::setSess($id,$atok);
            header("Content-Type: application/json; charset=UTF-8");
            header("Set-Cookie: auth_token={$atok};Secure;path=/; HttpOnly;SameSite=none");
            }
            die( json_encode(array("name"=>"Successful register","code"=>200)));
        }
        else{
            header("Content-Type: application/json; charset=UTF-8");
            die( json_encode(array("name"=>"Register failed","code"=>0,"d"=>$data[0])));
        }
 
    }
    public static function  run_event(){
        header("Content-Type: application/json; charset=UTF-8");
        die( json_encode(array("time"=>time(),"method0"=>"modal.open","data"=>"")));

    }
    public static function  run_suggestions($str){
        $arr=DataStorageController::findAll($str);


        header("Content-Type: application/json; charset=UTF-8");
        die( json_encode($arr));

    }
    public static function  run_logout(){
        $cookie=Request::cookie('auth_token');
        if( $cookie){
            DB::unsetSess($cookie);
            
        }    
      header("Set-Cookie: auth_token=;Secure;path=/; HttpOnly;SameSite=none");
      //header('Clear-Site-Data: "cookies"');
      //Request::redirect();
      die( json_encode(array("method0"=>"page.refresh","data"=>"")));
    }
    public static function  run_records(){
        if(!empty(Request::$route->params[0])){
            self::run(Request::$method.'_'.Request::$route->action.'_'.Request::$route->params[0]);
        }
    }
    protected static  function get_records_list(){
        $arr=DataStorageController::getList();
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        die( Helpers\Json::encode($arr));
    }



}