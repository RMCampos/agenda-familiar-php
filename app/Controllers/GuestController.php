<?php

namespace App\Controllers;

class GuestController extends Controller {
    public function getIndex($request, $response) {
        return $this->view->render($response, 'index.twig');
    }
    
    public function getSobre($request, $response) {
        return $this->view->render($response, 'sobre.twig');
    }
    
    public function getContato($request, $response) {
        $nomeHTML = '';
        if ($this->auth->check()) {
            $nomeHTML = preg_replace('/\s+/', '%20', $this->auth->user()->nome);
        }
        return $this->view->render($response, 'contato.twig', compact('nomeHTML'));
    }
    
    public function postContato($request, $response) {
        $nome = $request->getParam('nome');
        $email = $request->getParam('email');
        $assunto = "[RJAnivers.tk] " . $request->getParam('assunto');
        $receber = $request->getParam('mecopiar') == "on";
        $corpo = $request->getParam('conteudo');
        
        $cabecalhos =
            "MIME-Version: 1.0" . "\r\n".
            "Content-type: text/html; charset=utf-8" . "\r\n".
            "To: Ricardo Montania <ricardo.montania@gmail.com> " . "\r\n".
            "From: $nome <$email>" . "\r\n";
            
        if ($receber) {
            $cabecalhos .= "Cc: $nome <$email>" . "\r\n";
        }
        
        $cabecalhos .=
            "Reply-To: $nome <$email>" . "\r\n".
            "X-Mailer: PHP/".phpversion() . "\r\n";
            
        mail("ricardo.montania@gmail.com", $assunto, $corpo, $cabecalhos);
        $this->flash->addMessage('success', 'E-mail enviado com sucesso!');
        return $response->withRedirect($this->router->pathFor('contato'));
    }
}