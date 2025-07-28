<?php

class Router {
    private $routes = [];

    public function addRoute($method, $uri, $callback) {
        $this->routes[$method][$uri] = $callback;
    }

    public function dispatch($method, $uri) {
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            return true;
        }
        return false;
    }
}