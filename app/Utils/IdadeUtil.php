<?php

namespace App\Utils;

class IdadeUtil {
    public static function calcularIdade($dia, $mes, $ano) {
        if (!$ano) {
            return 0;
        }
        
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        
        return $idade;
    }
}