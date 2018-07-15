<?php

namespace MyApp\renderer;

class TwigRenderer
{

    public $templateFolder;
    protected $templateExtension;


    public function __construct($templateFolder, $templateExtension)
    {
        $this->templateExtension = $templateExtension;
        $this->templateFolder = $templateFolder;
    }

    public function render($template, array $params = [])
    {
        $loader = new \Twig_Loader_Filesystem($this->templateFolder);

        $twig = new \Twig_Environment($loader, array('cache' => 'compilation_cache', 'auto_reload' => true));

        $templateInstance = $twig->loadTemplate($template . $this->templateExtension );

        $content = $templateInstance->render($params);

        return $content;

    }
}

?>