<?php

namespace Framework;

class Router
{
    private $routes = [];
    private $notFoundHandler;

    public function get(string $path, callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function setNotFoundHandler(callable $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function dispatch(Request $request, Response $response): void
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        $handler = $this->routes[$method][$uri] ?? null;

        if ($handler) {
            call_user_func($handler, $request, $response);
        } else {
            if ($this->notFoundHandler) {
                call_user_func($this->notFoundHandler, $request, $response);
            } else {
                $response->setStatusCode(404);
                $response->setBody('404 Not Found');
                $response->send();
            }
        }
    }
}
