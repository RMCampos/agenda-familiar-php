<?php

namespace App\Controllers;

use App\Models\Calendarios;
use App\Models\Datas;
use App\Utils\SignoUtil;
use Respect\Validation\Validator as v;

class CalendarioController extends Controller {
    // GET
    public function getId($request, $response) {
        $c = Calendarios::find($request->getAttribute('id'));
        return $response->withJson($c);
    }
    
    // GET
    public function getPage($request, $response) {
        $calendarios = Calendarios::where('id_usuarios', $this->auth->user()->id)->orderBy('nome')->get();
        foreach ($calendarios as $c) {
            $c->total = Datas::where('id_calendarios', $c->id)->count();
        }
        
        return $this->view->render($response, 'calendarios.twig', compact('calendarios'));
    }
    
    // PUT
    public function create($request, $response) {
        $validation = $this->validator->validate($request, [
            'nome' => v::notEmpty()->stringType()->length(3, 100),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        Calendarios::create([
            'id_usuarios' => $this->auth->user()->id,
            'nome' => $request->getParam('nome'),
        ]);
        
        $this->flash->addMessage('success', 'Calendário cadastrado com sucesso!');
        return $response->withRedirect($this->router->pathFor('calendarios'));
    }
    
    // POST
    public function update($request, $response) {
        $validation = $this->validator->validate($request, [
            'nome' => v::notEmpty()->stringType()->length(3, 100),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $c = Calendarios::find($request->getParam('id'));
        if (!$c) {
            $this->flash->addMessage('error', 'Calendário não encontrado para alteração!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $c->nome = $request->getParam('nome');
        $c->save();
        
        $this->flash->addMessage('success', 'Calendário alterado com sucesso!');
        return $response->withRedirect($this->router->pathFor('calendarios'));
    }
    
    // DELETE
    public function delete($request, $response) {
        $id = $request->getParam('id');
        $calendario = Calendarios::find($id);
        
        if (!$calendario) {
            $this->flash->addMessage('error', 'Calendário não encontrado!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        if (Datas::where('id_usuarios', $this->auth->user()->id)->where('id_calendarios', $calendario->id)->count() > 0) {
            $this->flash->addMessage('error', 'Calendário não pode ser excluído, está em uso!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $rows = $calendario->delete();
        
        if ($rows == 0) {
            $this->flash->addMessage('error', 'Calendário não excluído!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $this->flash->addMessage('success', 'Calendário excluído com sucesso!');
        return $response->withRedirect($this->router->pathFor('calendarios'));
    }
}