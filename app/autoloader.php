<?php
class Autoloader
{
    public static function init()
    {
        spl_autoload_register(function ($class) {
            if (file_exists(Mod::getDirRoot() . '/core/' . strtolower($class) . '.php')) {
               include  Mod::getDirRoot() . '/core/' . strtolower($class) . '.php';
           }
       });
        spl_autoload_register(function ($class) {
            if (file_exists(Mod::getDirRoot() . '/core/classes/' . strtolower($class) . '.php')) {
                include  Mod::getDirRoot() . '/core/classes/' . strtolower($class) . '.php';
            }

        });
        
        spl_autoload_register(function ($class) {
            $file = str_replace('\\',DIRECTORY_SEPARATOR, strtolower($class));
            if (file_exists(Mod::getDirRoot().'/core/classes/' . DIRECTORY_SEPARATOR . $file . '.php')) {
                include  Mod::getDirRoot().'/core/classes/' . DIRECTORY_SEPARATOR . $file . '.php';
            }

        });
        spl_autoload_register(function ($class) {
            $cl = explode('_', $class);
             if (file_exists(Mod::getDirRoot() . '/core/api/' . strtolower($cl[0])  . '/'. strtolower($cl[1]) . '.php')) {
                include  Mod::getDirRoot() . '/core/api/' . strtolower($cl[0]) . '/' . strtolower($cl[1]) . '.php';
            }
        });
      
       
    }
}
