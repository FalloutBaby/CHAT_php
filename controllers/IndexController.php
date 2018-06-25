<?php

namespace controllers;

use MyApp\Auth;
use MyApp\Controller;
use models\Account;
use models\User;

class IndexController extends Controller
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

        $this->render('account/index', ['account' => $account,]);
    }
}