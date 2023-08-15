<?php
class User{
    private $isAuthorised=false;
    private $permissions=null;
    private $roles=null;
    private $user_id=null;
    private function __construct(){

    }
    public static function init(){
        $u=new User();
        //получение всех данных о пользователе
        $u->checkAuth();
        return $u;
    }
    private function checkAuth(){
        $this->isAuthorised=false;
        //механизм проверки 
        $cookie=Request::cookie('auth_token');
        if( $cookie){
            $usr=DB::hasSess($cookie);
            if($usr){
                $this->user_id=$usr;
                $this->isAuthorised=true;
            }
        }    
    }
    public function isAuthorised(){
        $this->checkAuth();
        return $this->isAuthorised;
    }
    public function getUserInfo(){
        
        return DB::getUser($this->user_id);
    }

    public function hasPermission(){
      //**** */
    }

    public function hasRole(){
        //**** */
    }

}