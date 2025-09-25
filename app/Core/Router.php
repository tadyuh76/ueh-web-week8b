<?php
namespace App\Core;

class Router {
    private $routes = [];
    private $defaultController = 'Product';
    private $defaultAction = 'index';
    
    public function add($route, $controller, $action = 'index', $method = 'GET') {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }
    
    public function dispatch($uri) {
        $uri = $this->sanitizeUri($uri);
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach ($this->routes as $route) {
            $pattern = $this->createPattern($route['route']);
            
            if (preg_match($pattern, $uri, $matches) && $route['method'] == $method) {
                array_shift($matches);
                return $this->callController($route['controller'], $route['action'], $matches);
            }
        }
        
        return $this->handleDefaultRoute($uri);
    }
    
    private function sanitizeUri($uri) {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        return $uri ?: '/';
    }
    
    private function createPattern($route) {
        $route = str_replace('/', '\/', $route);
        $route = preg_replace('/\{(\w+)\}/', '([^\/]+)', $route);
        return '/^' . $route . '$/';
    }
    
    private function callController($controllerName, $action, $params = []) {
        $controllerClass = "\\App\\Controllers\\" . $controllerName . "Controller";
        
        if (!class_exists($controllerClass)) {
            $this->show404();
            return;
        }
        
        $controller = new $controllerClass();
        
        if (!method_exists($controller, $action)) {
            $this->show404();
            return;
        }
        
        call_user_func_array([$controller, $action], $params);
    }
    
    private function handleDefaultRoute($uri) {
        if ($uri === '/' || $uri === '') {
            $this->callController($this->defaultController, $this->defaultAction);
        } else {
            $parts = explode('/', $uri);
            $controller = ucfirst($parts[0]);
            $action = $parts[1] ?? $this->defaultAction;
            $params = array_slice($parts, 2);
            
            $this->callController($controller, $action, $params);
        }
    }
    
    private function show404() {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        exit();
    }
    
    public function setDefaultRoute($controller, $action = 'index') {
        $this->defaultController = $controller;
        $this->defaultAction = $action;
    }
}