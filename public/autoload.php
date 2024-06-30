<?php
// ======================= WARNING ===========================
// DO NOT CHANGE THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING!
// ===========================================================

// SRC AUTOLOADER
spl_autoload_register(function ($class) {
    $file = __DIR__. DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

// LIB AUTOLOADER
spl_autoload_register(function ($class) {
    $file = __DIR__. DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});
