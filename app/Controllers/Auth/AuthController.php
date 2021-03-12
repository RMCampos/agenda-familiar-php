<?php

namespace App\Controllers\Auth;

use App\Models\Usuarios;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller {
    public function getSair($request, $response) {
        $this->auth->loggout();
        return $response->withRedirect($this->router->pathFor('index'));
    }
    
    public function getEntrar($request, $response) {
        return $this->view->render($response, 'entrar.twig');
    }
    
    public function postEntrar($request, $response) {
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('senha')
        );
        
        if (!$auth) {
            $this->flash->addMessage('error', 'Usuário ou senha inválidos.');
            return $response->withRedirect($this->router->pathFor('entrar'));
        }
        
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getRegistrar($request, $response) {
        return $this->view->render($response, 'registrar.twig');
    }
    
    public function postRegistrar($request, $response) {
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'nome' => v::notEmpty()->alpha(),
            'senha' => v::noWhitespace()->notEmpty(),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('registrar'));
        }
        
        $user = Usuarios::create([
            'email' => $request->getParam('email'),
            'nome' => $request->getParam('nome'),
            'senha' => password_hash($request->getParam('senha'), PASSWORD_DEFAULT),
        ]);
        
        $this->flash->addMessage('success', 'Você efetuou o login com sucesso!');
        
        $this->auth->attempt($user->email, $request->getParam('senha'));
        
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getResetar($request, $response) {
        return $this->view->render($response, 'resetar.twig');
    }
    
    public function postResetar($request, $response) {        
        $usuario = Usuarios::where('nome', $request->getParam('nome'))->first();
        
        if (!$usuario) {
            $this->flash->addMessage('error', 'Usuário não encontrado!');
            return $response->withRedirect($this->router->pathFor('resetar'));
        }
        
        $_SESSION['confirmar'] = $usuario->id;
        return $response->withRedirect($this->router->pathFor('confirmar'));
    }
    
    public function getConfirmar($request, $response) {
        if (!isset($_SESSION['confirmar'])) {
            $this->flash->addMessage('error', 'Usuário não encontrado!');
            return $response->withRedirect($this->router->pathFor('resetar'));
        }
        $usuario = Usuarios::find($_SESSION['confirmar']);
        unset($_SESSION['confirmar']);
        return $this->view->render($response, 'confirmar.twig', compact('usuario'));
    }
    
    public function postConfirmar($request, $response) {
        $usuario = Usuarios::where('email', $request->getParam('email'))->first();
        if (!$usuario) {
            $this->flash->addMessage('error', 'Usuário não encontrado!');
        }
        else {
            $usuario->senha = password_hash($request->getParam('senha'), PASSWORD_DEFAULT);
            $usuario->save();
            
            $this->flash->addMessage('success', 'Senha alterada com sucesso!');
        }
        
        return $response->withRedirect($this->router->pathFor('resetar'));
    }
}