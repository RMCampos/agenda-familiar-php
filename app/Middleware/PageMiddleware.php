<?php

namespace App\Middleware;

class PageMiddleware extends Middleware {
    public function __invoke($request, $response, $next) {
        $this->container->view->getEnvironment()->addGlobal('page', substr($request->getRequestTarget(), 1));
        
        if (isset($_SESSION['AniversarioNumPage']) && strpos($request->getRequestTarget(), '/Aniversarios') === FALSE) {
            $_SESSION['AniversarioNumPage'] = 1;
        }
        
        $response = $next($request, $response);
        return $response;
    }
}