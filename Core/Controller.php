<?php

namespace Core;

abstract class Controller
{
    public function view(string $view, array $data = []): void
    {
        extract($data);
        
        $baseDir = dirname(__DIR__); 
        $viewFile = $baseDir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $baseDir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'app.php';
        } else {
            die("View {$view} não encontrada.");
        }
    }
}
