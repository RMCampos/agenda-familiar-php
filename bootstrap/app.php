<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/paginator.php';
require __DIR__ . '/database.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => $isDevelopment,
        'db' => [
            'driver'    => $databaseDriver,
            'host'      => $databaseHost,
            'database'  => $databaseName,
            'username'  => $databaseUser,
            'password'  => $databasePass,
            'charset'   => $databaseCharset,
            'collation' => $databaseCollation,
        ]
    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

$container['auth'] = function($container) {
    return new \App\Auth\Auth;
};

$container['flash'] = function($container) {
    return new \Slim\Flash\Messages;
};

$container['view'] = function($container) {
    $view = \App\View\Factory::getEngine();

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);
    
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    
    return $view;
};

$container['validator'] = function($container) {
    return new \App\Validation\Validator;
};

$container['AuthController'] = function($container) {
    return new \App\Controllers\Auth\AuthController($container);
};

$container['GuestController'] = function($container) {
    return new \App\Controllers\GuestController($container);
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container);
};

$container['CalendarioController'] = function($container) {
    return new \App\Controllers\CalendarioController($container);
};

$container['AniversarioController'] = function($container) {
    return new \App\Controllers\AniversarioController($container);
};

$container['csrf'] = function($container) {
    return new \Slim\Csrf\Guard;
};

$app->add(new \App\Middleware\PageMiddleware($container));
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
