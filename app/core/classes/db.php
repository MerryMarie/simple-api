<?php
class DB{
    private static $db=null;
    /*public function __constract(){

    }
    public function __destract(){

    }*/

    public static function init(){
        self::$db=new SQLite3('test.db');
    }
    public static function query($sql){
        //$sql = 'SELECT * FROM `users`';
        $arr=[];
        $result = self::$db->query($sql);
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $arr[]=$row;
        }
        return $arr??null;
    }
    public static function hasSess($token){
        $sql = "SELECT * FROM `sess` WHERE `auth_token`='{$token}' LIMIT 1;";
        $result = self::$db->query($sql);
        if($result){
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return  $row['user_id']??false;
        }
        return false;
    }
    public static function getUser($id){
        $sql = "SELECT * FROM `users` WHERE `id`={$id} LIMIT 1;";
        $result = self::$db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return  $row??false;
    }
    public static function existUser($login){
        $sql = "SELECT * FROM `users` WHERE `login`='{$login}' LIMIT 1;";
        $result = self::$db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return  $row??false;
    }
    public static function addUser($login,$hash){
        $sql = "INSERT INTO users (login, pass_hash) VALUES ('{$login}', '{$hash}')";
        $result = self::$db->exec($sql);
        return  self::$db->lastInsertRowID()??null;
    }
    public static function setSess($id,$token){
        $sql = "INSERT INTO sess (user_id, auth_token) VALUES ({$id}, '{$token}')";
        $result = self::$db->exec($sql);
        
        return  $result;
    }
    public static function unsetSess($token){
        $sql = "DELETE FROM sess WHERE `auth_token`='{$token}'";
        $result = self::$db->exec($sql);
        
        return  $result;
    }
    public static function checkCreds($login,$hash){
        $sql = "SELECT * FROM `users` WHERE `login`='{$login}' AND `pass_hash`='{$hash}' LIMIT 1;";
        $result = self::$db->query($sql);
        if($result){
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return  $row??false;
        }
        return false;
    }


}