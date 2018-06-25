<?php

namespace MyApp;

class Request
{
    protected $controller = 'index';
    protected $action = 'index';
    protected $controllerNamespace = 'controllers';
    public $inputArr = [
        'get' => [],
        'post' => [],
    ];
	
	// Для тестирования
	public function getInfo($param)
    {
		if(!empty($this->$param)) {
			return $this->$param;
		}
		return false;
	}
	
    public function init()
    {
        $url =  strtolower($_SERVER['REQUEST_URI']);

        $this->inputArr['get']  = $_GET;
        $this->inputArr['post'] = $_POST;
		
        if ($cleanUrl = stristr($url, '?', true)) {
    		$path = explode('/', $cleanUrl);
		} else {
    		$path = explode('/', $url);
		}
		
        if(count($path) == 3) {
            $this->controller = $path[1];
            $this->action = $path[2];
        } elseif (count($path) == 2 && !empty($path[1])) {
            $this->controller = $path[1];
        }
		if(empty($path[1])) {
			$path[1] = 'index';
		}
		if(empty($path[2])) {
			$path[2] = '';
		}
		// Получение инф-ии о запрошенной странице
		
		
		
		
		$page_content = file_get_contents (__DIR__ . '/../templates' . /* implode('/', $path) */"/index" . '.tmpl');
		preg_match_all( "|<title>(.*)</title>|sUSi", $page_content, $title);
		if (empty($title)) {
			$title = $_SERVER['REQUEST_URI'];
		}
		
		if (empty($_SESSION['views'])) {
			$_SESSION['views'] = [];
		}
		
		array_push ($_SESSION['views'], ['title' => $title[1], 'url' => strtolower($_SERVER['REQUEST_URI'])]);
		
        $classController = $this->controllerNamespace . '\\' . ucfirst($this->controller) . 'Controller';
		
        $action = 'action' . ucfirst($this->action);
			
        if(class_exists($classController)) {
            $instanceController = new $classController();
			// Передача гет и пост запросов в контроллер
			
			$instanceController->requestGet = $this->get();
			$instanceController->requestPost = $this->post();
            if(method_exists($instanceController,$action)) {
                call_user_func_array([$instanceController,$action],[]);
            } else {
                throw new \Exception('Метод не существует');
            }
        }
    }
	
    public function get($key = null) {
        if(empty($key)) {
            return $this->inputArr['get'];
        }

        if(isset($this->inputArr['get'][$key])) {
            return $this->inputArr['get'][$key];
        }

        return null;
    }

    public function post($key = null) {
        if(empty($key)) {
            return $this->inputArr['post'];
        }

        if(isset($this->inputArr['post'][$key])) {
            return $this->inputArr['post'][$key];
        }

        return null;
    }
}