<?php

namespace Core;

class Router
{
    protected mixed $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            
            if (file_exists('../app/Controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
                // Preparação para rotas futuras: cargo, funcionario, relatorio
                die("O módulo '{$url[0]}' está em desenvolvimento e estará disponível em breve.");
            }
            unset($url[0]);
        }

        $controllerClass = "\\App\\Controllers\\" . $this->controller;
        $this->controller = new $controllerClass();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}