<?php

namespace Controllers;

use MyApp\Auth;
use MyApp\Controller;
use Models\Account;
use Models\User;

class IndexController extends Controller
{
    public function actionIndex()
    {
        if(Auth::check()) {
            echo " Привет, " . $_SESSION['user'] . "! ";
        }
        $accountModel = new Account();
        $user = new User;
				
        $account = $accountModel->getAccount();

        $this->render('public/index', ['account' => $account,]);
    }
	
    public function actionRegister()
    {
        $accountModel = new Account();
		$accountModel->request = $this->requestArray();
		
        $account = $accountModel->registerAccount();
		
		echo $this->render('public/index', ['account' => $account,] );
	}

    public function actionLogin()
    {
		$accountModel = new Account();
		$accountModel->request = $this->requestArray();

        $account = $accountModel->loginAccount();
		
		echo $this->render('public/index', ['account' => $account,] );
    }
}