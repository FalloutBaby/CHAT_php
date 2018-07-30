<?php
namespace MyApp;
use MyApp\Auth;

class App
{
    public $request = null;
    public $auth = null;
    public $db = null;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->init();
        $this->auth = Auth::getInstance();
        $this->auth->init();
        $this->auth->session();

    }

    public function init() {

    }
}