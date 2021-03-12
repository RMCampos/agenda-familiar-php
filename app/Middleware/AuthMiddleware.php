<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware {
    public function __invoke($request, $response, $next) {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('error', 'Por favor, faça login para continuar.');
            return $response->withRedirect($this->container->router->pathFor('entrar'));
        }
        
        $response = $next($request, $response);
        return $response;
    }
}