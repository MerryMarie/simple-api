<?php
interface StorageHandler{
    public static function getUserObject($id);
    public static function getTableObject($table);
    public static function getEntObject($id);
}
class Ent{
    private $field = array();
    public function __construct($arr){
        $this->field=$arr;
    }
    public function __get($name)
   {
      if(isset($this->field[$name]))
        return $this->field[$name];
      else
        throw new Exception("$name dow not exists");
   }
   public function __set($name,$val)
   {
      if(isset($this->field[$name]))
        $this->field[$name]=$val;
      else
        throw new Exception("$name dow not exists");
   }




}
class NewEnt{
    private $field = array();
    private $isNew=true;
    public function __construct($id){
        $this->field=Storage::getTableObject('users');
    }
    public function isNew()
	{
		return $this->isNew;
	}
    public function __get($name)
   {
      if(isset($this->field[$name]))
        return $this->field[$name];
      else
        throw new Exception("$name dow not exists");
   }
   public function __set($name,$val)
   {
      if(isset($this->field[$name]))
        $this->field[$name]=$val;
      else
        throw new Exception("$name dow not exists");
   }
   public function loadEnt($id){
         $this->field=Storage::getEntObject($id);
         $this->isNew=false;
        
   }
   public function save(){
        $this->isNew()?$this->update():$this->create();
   }
   private function update(){
    if ( ! $this->isNew())
        throw new Exception('Cannot update entity because it is not loaded.');
   }
   private function create(){
    
   }
   


}

class Storage{
    private static $ent=null;
    public static function getUserObject($id){
        $arr=array();
        $s=DB::getUser($id);
        foreach(DB::query("PRAGMA table_info(users);") as $k=>$v){
            $arr[$v['name']]=(string)$s[$v['name']];
        }



        self::$ent=new Ent($arr);
        return self::$ent;

    } 
    public static function getEntObject($id){
        $arr=array();
        $s=DB::getUser($id);
        foreach(DB::query("PRAGMA table_info(users);") as $k=>$v){
            $arr[$v['name']]=(string)$s[$v['name']];
        }

        return $arr;

    } 
    public static function getTableObject($table){
        $arr=array();

        foreach(DB::query("PRAGMA table_info({$table});") as $k=>$v){
            $arr[$v['name']]="";
        }

        return $arr;
    }

    

}