<?php

spl_autoload_register('MVCAutoloader');
function MVCAutoloader($class)
{
    if (substr($class, 0, 4) == 'MVC\\') {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file_theme = get_template_directory() . DIRECTORY_SEPARATOR . $class . '.php';
        $file = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 4)) . '.php';
        if (file_exists($file_theme)) {
            require_once($file_theme);
        } elseif (file_exists($file)) {
            require_once($file);
        } elseif (WP_DEBUG) {
            throw new Exception("File [ $file ] or [ $file_theme ] not found");
        }
    }
}