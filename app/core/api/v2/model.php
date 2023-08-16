<?php
use Helpers\Validator as Validator;
class V2_Model extends Model{
    
    public static function run_index(){
        Response::setStatus(200);
        Response::setData(["app_name"=>"FireNote"]);
        Response::send();
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
            Response::setStatus(200);
            Response::setData(["username"=>$usr["login"],"auth"=>"true"]);
      
        }else{
            Response::setStatus(400);
            Response::setData(["auth"=>"false"]);
        }

        Response::send();
    }
    protected static  function get_countries_list(){
        $arr=DataStorageController::getList();
        Response::setStatus(200);
        Response::setData($arr);
        Response::send();
    }
    public static function  run_register($data){

        if(Validator::isValidLogin($data[0])){
            $usr=DB::existUser($data[0]);

            if(!$usr){
                $id=DB::addUser(htmlspecialchars(strip_tags($data[0])),md5(htmlspecialchars(strip_tags($data[0]))));

                if($id){
                    $atok=md5(time().uniqid());
                    DB::setSess($id,$atok);
                    Response::setCookie("auth_token",$atok);
                    Response::setStatus(200);
                    Response::setData(["username"=>$usr['login']]);
                }
                else{
                    Response::setStatus(400);
                    Response::setError('Unexpected error!');
                
                }
        
            }else{
                Response::setStatus(400);
                Response::setError('User already exists!');
            }
    
        }else{
            Response::setStatus(400);
            Response::setError('Invalid Login!');
        }

         Response::send();
    }

    public static function  run_logout(){
        $cookie=Request::cookie('auth_token');
        if( $cookie){
            DB::unsetSess($cookie);
            
        }    
        Response::setCookie("auth_token","");
        Response::setStatus(200);
        Response::send();
    }

    public static function  run_login($data){
        
        if($data[0]&& $data[1]){
         
            $usr=DB::checkCreds(htmlspecialchars(strip_tags($data[0])),md5(htmlspecialchars(strip_tags($data[1]))));
            if($usr){
         
            $atok=md5(time().uniqid());
            DB::setSess($usr['id'],$atok);
            Response::setCookie("auth_token",$atok);
            Response::setStatus(200);
            Response::setData(["username"=>$usr['login']]);

           
            }
            else{
                Response::setStatus(400);
                Response::setData(["username"=>""]);
                Response::setError('Wrong login or password!');
              
            }
        }else{
            Response::setStatus(403);
            Response::setData(["username"=>""]);
            Response::setError('Unexpected mistake!');
        }

        Response::send();
    }
}