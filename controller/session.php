<?php
/**
 * Created by PhpStorm.
 * User: amir's dell
 * Date: 5/17/2017
 * Time: 6:45 PM
 */

class session{

    private static function start(){
        if(self::check()){
            @session_start();
            return true;
        }
        return false;
    }

    public static function set($key, $value){
        if(self::start()){
            $_SESSION[$key] = $value;
            return true;
        }
        return false;

    }

    public static function get($name, $key){
        if(self::start()){

        }
    }

    private static function check(){
        if(!isset($_SESSION))
            return false;
        return true;
    }

}