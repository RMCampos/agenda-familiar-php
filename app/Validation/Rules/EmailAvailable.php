<?php

namespace App\Validation\Rules;

use App\Models\Usuarios;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule {
    public function validate($input) {
        return Usuarios::where('email', $input)->count() === 0;
    }
}