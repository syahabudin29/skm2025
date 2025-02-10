<?php
class Router {
    private $routes = [];
    
    public function addRoute($path, $handler) {
        $this->routes[$path] = $handler;
    }
    
    public function handleRequest() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        
        // Validasi input
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        
        // Cek apakah user sudah login
        if (!isset($_SESSION['admin']) && $page != 'login') {
            header("Location: login.php");
            exit();
        }
        
        // Map routes ke file views
        $viewFile = '';
        switch($page) {
            case 'dashboard':
                $viewFile = 'views/dashboard.php';
                break;
            case 'users':
                $viewFile = 'views/users.php';
                break;
            case 'survey-responses':
                $viewFile = 'views/survey_responses.php';
                break;
            default:
                $viewFile = 'views/dashboard.php';
        }
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Halaman tidak ditemukan";
        }
    }
} 