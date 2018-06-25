<?php

namespace MyApp;

// use components\renderer\TwigRenderer;

class Controller 
{
	public $requestPost;
	public $requestGet;
	
	public function requestArray()
	{
		return ['post' => $this->requestPost, 'get' => $this->requestGet ];
	}
	
    protected function render($template, array $params = [])
    {
        $render = new TwigRenderer('../templates/', '.tmpl');
		$result = $render->render($template, $params);
		echo $result;
    }
}

?>