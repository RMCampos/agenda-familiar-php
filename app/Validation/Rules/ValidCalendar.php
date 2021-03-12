<?php

namespace App\Validation\Rules;

use App\Models\Calendarios;
use Respect\Validation\Rules\AbstractRule;

class ValidCalendar extends AbstractRule {
    protected $idUsuario;
    
    public function __construct($id) {
        $this->idUsuario = $id;
    }
    
    public function validate($input) {
        return Calendarios::where('id_usuarios', $this->idUsuario)->where('id', $input)->count() > 0;
    }
}