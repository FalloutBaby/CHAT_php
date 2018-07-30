<?php

namespace MyApp;

class Auth
{
    use \MyApp\Traits\Singletone;
	
    public function init()
    {
		//Проверяем авторизацию
		
        if(!empty($_SESSION['user'])) { 
    		return $_SESSION['user'];
		} else {
			return false;
		}
    }

    public static function check()
    {
		if(!empty($_SESSION['user'])) { 
    		return true;
		} else {
			return false;
		}
    }
	
	public function session()
    {
		
    }
}