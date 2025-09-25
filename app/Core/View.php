<?php
namespace App\Core;

class View {
    private $layout = 'main';
    private $data = [];
    
    public function setLayout($layout) {
        $this->layout = $layout;
    }
    
    public function render($viewPath, $data = []) {
        $this->data = $data;
        extract($data);
        
        $viewFile = __DIR__ . '/../Views/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        
        if ($this->layout) {
            $layoutFile = __DIR__ . '/../Views/layouts/' . $this->layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    
    public function renderPartial($viewPath, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . '/../Views/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        require $viewFile;
    }
    
    public function escape($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}