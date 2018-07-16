<?php

namespace Controllers;

use MyApp\Auth;
use MyApp\Controller;
use Models\Account;
use Models\User;

class PublicController extends Controller
{
    public function actionIndex()
    {
        if(Auth::check()) {
            echo " Привет, " . $_SESSION['user'] . "! ";
        }
        $accountModel = new Account();

        $user = new User;
        $post_data= [

        //    'name' => 'name from model',
        //    'login' => 'sdfdsf'

        ];
        $account = $accountModel->getAccount();

        $this->render('public/index', ['account' => $account,]);
    }
	public function actionChat()
    {
        $accountModel = new Account();
		$accountModel->request = $this->requestArray();
		
        $account = $accountModel->registerAccount();
		
		echo $this->render('public/chat', ['account' => $account,] );
	}
}