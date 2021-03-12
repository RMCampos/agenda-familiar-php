<?php

namespace App\Controllers;

class Controller {
    protected $container;
    
    public function __construct($container) {
        $this->container = $container;
    }
    
    public function __get($property) {
        if ($this->container->{$property} ) {
            return $this->container->{$property};
        }
    }
    
    protected function getTotalPaginas($totalRegistros) {
        $totalPaginas = 1;
        $itensPorPagina = 8;
        
        if ($totalRegistros > 8) {
            $totalPaginas = intval($totalRegistros/8);
            $resto = $totalRegistros % 8;
            if ($resto > 0) {
                $totalPaginas++;
            }
        }
        
        return $totalPaginas;
    }
}