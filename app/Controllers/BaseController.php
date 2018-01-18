<?php
namespace App\Controllers;

class BaseController {

    public $templateEngine;

    public function __construct() {
        // Inicializar motor de template
        $loader = new \Twig_Loader_Filesystem('../views');
        $this->templateEngine = new \Twig_Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);

    }
    public function render($fileName, $data){
        return $this->templateEngine->render($fileName,$data);
    }
}