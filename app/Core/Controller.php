<?php
namespace App\Core;

abstract class Controller {
    protected $view;
    
    public function __construct() {
        $this->view = new View();
    }
    
    protected function model($modelName) {
        $modelClass = "\\App\\Models\\" . $modelName;
        if (class_exists($modelClass)) {
            return new $modelClass();
        }
        throw new \Exception("Model {$modelName} not found");
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    protected function getRequestData() {
        return $_REQUEST;
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    protected function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    protected function validateRequired($data, $fields) {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Field '{$field}' is required";
            }
        }
        return $errors;
    }
}