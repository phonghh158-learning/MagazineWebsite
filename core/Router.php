<?php

namespace Core;

class Router {
    private static $routes = [];

    public static function get($uri, $callback) {
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback) {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
        // Kiểm tra route tĩnh trước
        if (isset(self::$routes[$method][$uri])) {
            $callback = self::$routes[$method][$uri];
    
            if (is_array($callback)) {
                $controller = new $callback[0]();
                $method = $callback[1];
                call_user_func([$controller, $method]);
            } else {
                call_user_func($callback);
            }
            return; // Quan trọng: Dừng lại nếu đã tìm thấy route
        }
    
        // Kiểm tra route động
        foreach (self::$routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{[\w]+\}/', '([\w-]+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches); // Loại bỏ phần tử đầu tiên (full match)
    
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $method = $callback[1];
                    call_user_func_array([$controller, $method], $matches);
                } else {
                    call_user_func_array($callback, $matches);
                }
                return;
            }
        }
    
        // Không tìm thấy route -> 404
        http_response_code(404);
        echo "404 - Not Found";
    }
    
    
}
