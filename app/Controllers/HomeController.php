<?php

namespace App\Controllers;

use App\Models\Calendarios;
use App\Models\Datas;
use App\Utils\SignoUtil;
use App\Utils\IdadeUtil;
use App\Utils\SortUtil;

class HomeController extends Controller {
    public function getHome($request, $response) {
        /*
        $mesAtual = date('n');
        if (isset($_SESSION['HomeMesAtual'])) {
            $mesAtual = $_SESSION['HomeMesAtual'];
        }
        
        $idAtual = 0;
        if (isset($_SESSION['HomeIdAtual'])) {
            $idAtual = $_SESSION['HomeIdAtual'];
        }
        
        $ordem = 'DATA';
        if (isset($_SESSION['HomeOrdem'])) {
            $ordem = $_SESSION['HomeOrdem'];
        }
        
        $mostrarSignos = 'SIM';
        if (isset($_SESSION['HomeSignos'])) {
            $mostrarSignos = $_SESSION['HomeSignos'];
        }
        
        $sinalMes = '=';
        if ($mesAtual == 13) {
            $sinalMes = '!=';
        }
        $sinalCalendario = '=';
        if ($idAtual == 0) {
            $sinalCalendario = '>';
        }
        
        $calendarios = Calendarios::where('id_usuarios', $this->auth->user()->id)->orderBy('nome')->get();
        
        $datas = Datas::join('calendarios', 'calendarios.id', '=', 'datas.id_calendarios')
            ->where('datas.id_usuarios', '=', $this->auth->user()->id)
            ->where('mes', $sinalMes, $mesAtual)
            ->where('datas.id_calendarios', $sinalCalendario, $idAtual)
            ->select('datas.id', 'datas.id_calendarios', 'datas.dia', 'datas.mes', 'datas.ano', 'datas.descricao', 'calendarios.nome');

        if ($ordem == 'NOME') {
            $datas->orderBy('descricao');
        }
        else if ($ordem == 'DATA') {
            $datas->orderBy('mes')->orderBy('dia');
        }
        
        $datas = $datas->get()->toArray();
        $array2 = array();
        
        foreach ($datas as $d) {
            $d["ocorreu"] = $d["mes"] < date('n') || ($d["mes"] <= date('n') && $d["dia"] <= date('j'));
            $d["hoje"] = $d["mes"] == date('n') && $d["dia"] == date('j');
            $d["idade"] = IdadeUtil::calcularIdade($d["dia"], $d["mes"], $d["ano"]);
            $d["linha"] =
                    str_pad($d["dia"], 2, '0', STR_PAD_LEFT) . '/' . str_pad($d["mes"], 2, '0', STR_PAD_LEFT) . ' - '
                    . $d["descricao"] . ($d["idade"] > 0? " (hoje com ".$d["idade"] . " anos)" : "");
            
            
            if ($mostrarSignos == 'NAO') {
                $d["linha"] .= ' (' . SignoUtil::getSigno($d["dia"], $d["mes"]) . ')';
            }
            
            array_push($array2, $d);
        }
        
        if ($ordem == 'IDADE') {
            usort($array2, function($a, $b) {
                return $a["idade"] - $b["idade"];
            });
        }
        
        $datas = $array2;
        */
        
        //return $this->view->render($response, 'home.twig', compact('calendarios', 'datas', 'ordem', 'mostrarSignos', 'mesAtual', 'idAtual'));

        $datas = Datas::orderBy('created_at', 'desc')->paginate(6)->appends($request->getParams());
        return $this->view->render($response, 'home.twig', compact('datas'));
    }
    
    public function postHome($request, $response) {
        $_SESSION['HomeMesAtual'] = $request->getParam('mesAtual');
        $_SESSION['HomeIdAtual'] = $request->getParam('idAtual');
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getHomeOrdem($request, $response) {
        $_SESSION['HomeOrdem'] = $request->getAttribute('ordem');
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getHomeSignos($request, $response) {
        $_SESSION['HomeSignos'] = $request->getAttribute('mostrar') == 'NAO' ? 'SIM' : 'NAO';
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getHomeJSON($request, $response) {
        $id = $request->getAttribute('id');
        
        if (!$id) {
            return $response->withJson([], 204);
        }
        
        $calendarios = Calendarios::where('id_usuarios', $id)->orderBy('nome')->get();
        $datas = Datas::join('calendarios', 'calendarios.id', '=', 'datas.id_calendarios')
            ->where('datas.id_usuarios', '=', $id)
            ->where('mes', '>', '0')
            ->where('datas.id_calendarios', '>', '0')
            ->select('datas.id', 'datas.id_calendarios', 'datas.dia', 'datas.mes', 'datas.ano', 'datas.descricao', 'calendarios.nome')
            ->orderBy('mes')->orderBy('dia')->get();

        $jsonData = array(
            'calendarios' => $calendarios,
            'datas' => $datas,
        );
        
        return $response->withJson($jsonData);
    }
}