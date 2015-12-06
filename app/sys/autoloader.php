<?php
spl_autoload_register(function ($class) {

    $baseDir = __DIR__ . '/../src/';

    $classFilePath = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($classFilePath)) {
        require $classFilePath;
    }
});