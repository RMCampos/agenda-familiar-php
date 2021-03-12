<?php

/*
CREATE TABLE IF NOT EXISTS grupos (
    id INTEGER AUTO_INCREMENT,
    usuario_id INTEGER NOT NULL,
    nome VARCHAR(100) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
);
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model {
    protected $table = 'grupos';
    
    protected $fillable = [
        'usuario_id',
        'nome',
    ];
}