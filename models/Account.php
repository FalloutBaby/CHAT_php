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
        	header('Location: login');
    	}
		return true;
	}
	
	public function loginAccount()
	{
		$this->database = new Database();
		$user = new User();
		
		if(!empty($this->request['post']['user']) && !empty($this->request['post']['password'])) {
			if(!$user->validate(['user' => $this->request['post']['user'], 'password' => md5($this->request['post']['password'])], $user->rules )) {
				return false;
			}
        	$user->values = $user->getOne('user', $this->request['post']['user']);
        	if($user->values['password'] == md5($this->request['post']['password']) ) {
				$_SESSION['user'] = $user->values['user'];
				$_SESSION['user_name'] = $user->values['user_name'];
				$_SESSION['user_id'] = $user->values['user_id'];
				header('Location: personal');
			} else {
				echo "Неверный логин или пароль";
			}
		}
	
		return $user;
	}
	
	public function showAccount()
	{
		$this->database = new Database();
		$user = new User();
		
		$user->values = $user->getOne('user', $_SESSION['user']);
		
		if(!empty($this->request['post']['user']) && !empty($this->request['post']['user_name'])) {
        	$user->values = $user->update('user_id', $user->values['user_id'], $this->request['post']);
			$_SESSION['user'] = $this->request['post']['user'];
        	$_SESSION['user_name'] = $this->request['post']['user_name'];
		} else if (!empty($this->request['post']['user'])) {
        	$user->values = $user->update('user_id', $user->values['user_id'], $this->request['post']);
        	$_SESSION['user'] = $this->request['post']['user'];
		} else if (!empty($this->request['post']['user_name'])) {
        	$user->values = $user->update('user_id', $user->values['user_id'], $this->request['post']);
        	$_SESSION['user_name'] = $this->request['post']['user_name'];
		}
		
		$user->values['views'] = $_SESSION['views'];
		if (!empty($user->values['views'])) {
			$user->values['views'] = array_reverse(array_map("unserialize",(array_unique(array_map("serialize",$user->values['views'])))));
			
			$user->values['views'] = array_slice($user->values['views'] , 0, 5);
		}
		return $user->values;
	}
	
	public function accountLogout()
	{
		unset($_SESSION['user']);
		header('Location: ../account');
	}
}

?>