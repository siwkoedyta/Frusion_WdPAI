<?php

class AppController{
     private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }
    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }
    
    protected function render(string $template, array $variables = []){
        $templatePath = 'src/views/'.$template.'.php';
        $output = 'File not found.';

        if(file_exists($templatePath)){
            extract($variables); //lista asocjacyjna zmiennych (słownik), funkcja wypakowuje klucze z listy i tworzy z niej zmienną o nazwie klucza

            ob_start(); //otwieramy strumień
            include $templatePath;
            $output = ob_get_clean(); //zamykamy strumień
        }

        print $output;
    }
    
}