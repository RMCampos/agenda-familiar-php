<?php

/*
CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    senha VARCHAR(120) NOT NULL,
    hash_reset VARCHAR(255) NULL,
    data_desativacao TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model {
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nome',
        'email',
        'senha',
        'hash_reset',
        'data_desativacao'
    ];
}