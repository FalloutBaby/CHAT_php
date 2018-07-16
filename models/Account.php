<?php

namespace Models;

use MyApp\Model;
use MyApp\Database;
use MyApp\Auth;
use MyApp\App;

class Account extends Model
{
    public $account = null;
	protected $database;
    
	public function getAccount()
    {
		$this->account = Auth::GetInstance();
        $response = $this->account->init();
		return $response;
    }
	
	public function registerAccount()
	{
		$this->database = new Database();
		$user = new User();
		
		if(!empty($this->request['post']['user']) && !empty($this->request['post']['password'])) {
			
        	$user->create(['user' => $this->request['post']['user'], 'password' => md5($this->request['post']['password'])]);
			
			return $user;
    	}
		return true;
	}
	
	public function loginAccount()
	{
		$this->database = new Database();
		$user = new User();
		
		if(!empty($this->request['post']['user']) && !empty($this->request['post']['password'])) {
			if(!$user->validate(['user' => $this->request['post']['user'], 'password' => md5($this->request['post']['password'])], $user->rules )) {
				echo "Неверный логин или пароль";
			}
        	$user->values = $user->getOne('user', $this->request['post']['user']);
        	if($user->values['password'] == md5($this->request['post']['password']) ) {
				$_SESSION['user'] = $user->values['user'];
				$_SESSION['user_name'] = $user->values['user_name'];
				$_SESSION['user_id'] = $user->values['user_id'];
				return $user;
			} else {
				return "Неверный логин или пароль";
			}
		}
	
		return $user;
	}
	
	public function accountLogout()
	{
		unset($_SESSION['user']);
	}
}

?>