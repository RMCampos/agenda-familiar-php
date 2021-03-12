<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->group('', function() {
    $this->get('/', 'GuestController:getIndex')->setName('index');
    
    $this->get('/criar-conta', 'AuthController:getRegistrar')->setName('registrar');
    $this->post('/criar-conta', 'AuthController:postRegistrar');

    $this->get('/acessar-conta', 'AuthController:getEntrar')->setName('entrar');
    $this->post('/acessar-conta', 'AuthController:postEntrar');
    
    $this->get('/resetar-senha', 'AuthController:getResetar')->setName('resetar');
    $this->post('/resetar-senha', 'AuthController:postResetar');
    
    $this->get('/confirmar-reset-senha', 'AuthController:getConfirmar')->setName('confirmar');
    $this->post('/confirmar-reset-senha', 'AuthController:postConfirmar');
    
})->add(new GuestMiddleware($container));

$app->group('', function() {
    $this->get('/home', 'HomeController:getHome')->setName('home');
    /*
    $this->post('/home', 'HomeController:postHome');
    $this->get('/home/Ordenar/{ordem}', 'HomeController:getHomeOrdem')->setName('home.ordenado');
    $this->get('/home/Signos/{mostrar}', 'HomeController:getHomeSignos')->setName('home.signos');
    */
    
    $this->get('/Calendarios/getId/{id}', 'CalendarioController:getId');
    $this->get('/Calendarios', 'CalendarioController:getPage')->setName('calendarios');
    $this->put('/Calendarios', 'CalendarioController:create');
    $this->post('/Calendarios', 'CalendarioController:update');
    $this->delete('/Calendarios', 'CalendarioController:delete');
    
    $this->get('/Aniversarios/getId/{id}', 'AniversarioController:getId');
    $this->get('/Aniversarios/Page/{numPage}', 'AniversarioController:getPageNum')->setName('aniversarios.page');
    $this->get('/Aniversarios/NextPage', 'AniversarioController:getNextPage')->setName('aniversarios.nextPage');
    $this->get('/Aniversarios/PreviousPage', 'AniversarioController:getPreviousPage')->setName('aniversarios.previousPage');
    $this->get('/cadastro-datas', 'AniversarioController:getPage')->setName('cadastro-datas');
    $this->put('/cadastro-datas', 'AniversarioController:create');
    $this->post('/Aniversarios', 'AniversarioController:update');
    $this->delete('/Aniversarios', 'AniversarioController:delete');
    
    $this->get('/Sair', 'AuthController:getSair')->setName('sair');
})->add(new AuthMiddleware($container));

$app->get('/sobre-nos', 'GuestController:getSobre')->setName('sobre');
$app->get('/contato', 'GuestController:getContato')->setName('contato');
$app->post('/contato', 'GuestController:postContato');

$app->get('/Home/JSON/{id}', 'HomeController:getHomeJSON');

/*
$app->get('/calendario/getAll', 'HomeController:calendarioGetAll');
$app->post('/calendario/create', 'HomeController:calendarioPostCreate');
$app->post('/calendario/delete', 'HomeController:calendarioPostDelete');
$app->post('/calendario/update', 'HomeController:calendarioPostUpdate');

$app->get('/dataAnual/getAll/{mes}/{calendario}/{ordenacao}', 'HomeController:dataAnualGetAll');
$app->post('/dataAnual/create', 'HomeController:dataAnualPostCreate');
$app->post('/dataAnual/delete', 'HomeController:dataAnualPostDelete');
$app->post('/dataAnual/update', 'HomeController:dataAnualPostUpdate');

$app->post('/login/create', 'LoginController:postCreate');
$app->get('/login/check/{hash}', 'LoginController:getCheck');
$app->post('/login/sair', 'LoginController:postSair');
$app->post('/login/authenticate', 'LoginController:postAuthenticate');
*/