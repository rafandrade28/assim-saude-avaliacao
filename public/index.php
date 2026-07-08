<?php

declare(strict_types=1);

// Autoloader simples baseado em PSR-4 para os namespaces App e Core
spl_autoload_register(function (string $class) {
    $prefixApp = 'App\\';
    $prefixCore = 'Core\\';
    
    $baseDirApp = __DIR__ . '/../app/';
    $baseDirCore = __DIR__ . '/../Core/';
    
    if (strncmp($prefixApp, $class, strlen($prefixApp)) === 0) {
        $relativeClass = substr($class, strlen($prefixApp));
        $file = $baseDirApp . str_replace('\\', '/', $relativeClass) . '.php';
    } elseif (strncmp($prefixCore, $class, strlen($prefixCore)) === 0) {
        $relativeClass = substr($class, strlen($prefixCore));
        $file = $baseDirCore . str_replace('\\', '/', $relativeClass) . '.php';
    } else {
        return;
    }
    
    if (file_exists($file)) {
        require $file;
    }
});

// Inicia a aplicação
$router = new \Core\Router();