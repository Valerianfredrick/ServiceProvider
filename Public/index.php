<?php 
//error handling code
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

class App {
    private $controller;
    private $method;
    private $params = [];

    public function __construct() {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];

            $matches = explode("/", trim($url, "/"));

            $this->controller = ucfirst(($matches[0])) ; 

            $this->method = isset($matches[1]) ? $matches[1] : "index";

            $this->params = array_slice($matches, 2);
        } else {
            $this->controller = "HomeController";
            $this->method = "home";
        }

        
        if (class_exists($this->controller)) {
            $controller = new $this->controller;

            if (method_exists($controller, $this->method)) {
        
                call_user_func_array([$controller, $this->method], $this->params);
            } else {
                echo "Method '{$this->method}' does not exist in {$this->controller}.";
            }
        } else {
            echo "Controller '{$this->controller}' does not exist.";
        }
    }
}
new App();
