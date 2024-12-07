<?php

class HomeController {

    public function __construct() {
        
    }

    public function home() {
        $file = "../App/View/home.html";
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Error: View file '{$file}' not found.";
        }
    }
}
