<?php

namespace App\Utils;

class SignoUtil {
    public static function getSigno($dia, $mes) {
        if (($mes == 3  && $dia >= 20) || ($mes == 4  && $dia <= 20)) {
            return "Áries";
        }
        if (($mes == 4  && $dia >= 21) || ($mes == 5  && $dia <= 20)) {
            return "Touro";
        }
        if (($mes == 5  && $dia >= 21) || ($mes == 6  && $dia <= 20)) {
            return "Gêmeos";
        }
        if (($mes == 6  && $dia >= 21) || ($mes == 7  && $dia <= 20)) {
            return "Câncer";
        }
        if (($mes == 7  && $dia >= 22) || ($mes == 8  && $dia <= 22)) {
            return "Leão";
        }
        if (($mes == 8  && $dia >= 23) || ($mes == 9  && $dia <= 22)) {
            return "Virgem";
        }
        if (($mes == 9  && $dia >= 23) || ($mes == 10 && $dia <= 22)) {
            return "Libra";
        }
        if (($mes == 10 && $dia >= 23) || ($mes == 11 && $dia <= 21)) {
            return "Escorpião";
        }
        if (($mes == 11 && $dia >= 22) || ($mes == 12 && $dia <= 21)) {
            return "Sagitário";
        }
        if (($mes == 12 && $dia >= 22) || ($mes == 1  && $dia <= 21)) {
            return "Capricórnio";
        }
        if (($mes == 1  && $dia >= 22) || ($mes == 2  && $dia <= 18)) {
            return "Aquário";
        }
        if (($mes == 2  && $dia >= 19) || ($mes == 3  && $dia <= 19)) {
            return "Peixes";
        }
    }
}