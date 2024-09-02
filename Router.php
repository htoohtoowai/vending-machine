<?php

class Router
{
    private $routes = [];

    public function addRoute($method, $uri, $handler)
    {
        $this->routes[$method][$uri] = $handler;
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes[$method] as $route => $handler) {
            // Convert route to a regex pattern
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                list($controller, $action) = explode('@', $handler);
                $controllerInstance = new $controller();
                
                if (method_exists($controllerInstance, $action)) {
                    return $controllerInstance->$action(...$matches);
                }
            }
        }

        // Handle 404 - Not Found
        http_response_code(404);
        echo "404 - Not Found";
    }
}
?>
