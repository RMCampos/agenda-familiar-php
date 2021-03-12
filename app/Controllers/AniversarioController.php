<?php

namespace App\Controllers;

use App\Models\Grupos;
use App\Models\Datas;
use App\Utils\SignoUtil;
use Respect\Validation\Validator as v;

class AniversarioController extends Controller {
    // GET
    public function getId($request, $response) {
        $a = Datas::find($request->getAttribute('id'));
        return $response->withJson($a);
    }
    
    // GET
    public function getPageNum($request, $response) {
        $numPage = $request->getAttribute('numPage');
        $_SESSION['AniversarioNumPage'] = $numPage;
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
    
    // GET
    public function getNextPage($request, $response) {
        $numPage = 1;
        if (isset($_SESSION['AniversarioNumPage'])) {
            $numPage = $_SESSION['AniversarioNumPage'] + 1;
        }
        $_SESSION['AniversarioNumPage'] = $numPage;
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
    
    // GET
    public function getPreviousPage($request, $response) {
        $numPage = 1;
        if (isset($_SESSION['AniversarioNumPage'])) {
            $numPage = $_SESSION['AniversarioNumPage'] - 1;
        }
        $_SESSION['AniversarioNumPage'] = $numPage;
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
    
    // GET
    public function getPage($request, $response) {
        $usuario_id = $this->auth->user()->id;
        
        $grupos = Grupos::where('usuario_id', $usuario_id)->orderBy('nome')->get();
        $datas = Datas::where('usuario_id', $usuario_id)->paginate(6)->appends($request->getParams());
        
        return $this->view->render($response, 'datas.twig', compact('datas', 'grupos'));
    }
    
    // PUT
    public function create($request, $response) {
        $validation = $this->validator->validate($request, [
            'dia' => v::intVal()->between(1, 31),
            'mes' => v::intVal()->between(1, 12),
            'descricao' => v::stringType()->length(1, 100),
            'id_calendarios' => v::intVal()->validCalendar($this->auth->user()->id),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('aniversarios'));
        }
        
        Datas::create([
            'id_usuarios'    => $this->auth->user()->id,
            'id_calendarios' => $request->getParam('id_calendarios'),
            'dia'            => $request->getParam('dia'),
            'mes'            => $request->getParam('mes'),
            'ano'            => $request->getParam('ano') == ""? NULL : $request->getParam('ano'),
            'descricao'      => $request->getParam('descricao'),
        ]);
        
        $obj = "Aniversário cadastrado";
        if ($request->getParam('ano') == "") {
            $obj = "Data cadastrada";
        }
        
        $this->flash->addMessage('success', $obj . ' com sucesso!');
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
    
    // POST
    public function update($request, $response) {
        $validation = $this->validator->validate($request, [
            'dia' => v::intVal()->between(1, 31),
            'mes' => v::intVal()->between(1, 12),
            'descricao' => v::stringType()->length(1, 100),
            'id_calendarios' => v::intVal()->validCalendar($this->auth->user()->id),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('aniversarios'));
        }
        
        $data = Datas::find($request->getParam('id'));
        if (!$data) {
            $this->flash->addMessage('error', 'Registro não encontrado para alteração!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $data->dia            = $request->getParam('dia');
        $data->mes            = $request->getParam('mes');
        $data->ano            = $request->getParam('ano') == ""? NULL : $request->getParam('ano');
        $data->descricao      = $request->getParam('descricao');
        $data->id_calendarios = $request->getParam('id_calendarios');
        $data->save();
        
        $obj = "Aniversário alterado";
        if ($request->getParam('ano') == "") {
            $obj = "Data alterada";
        }
        
        $this->flash->addMessage('success', $obj . ' com sucesso!');
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
    
    // DELETE
    public function delete($request, $response) {
        $rows = Datas::find($request->getParam('id'))->delete();
        
        $data = array();
        
        if ($rows == 0) {
            $this->flash->addMessage('error', 'Registro não excluído!');
            return $response->withRedirect($this->router->pathFor('calendarios'));
        }
        
        $this->flash->addMessage('success', 'Registro excluído com sucesso!');
        return $response->withRedirect($this->router->pathFor('aniversarios'));
    }
}