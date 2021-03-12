<?php

/*
CREATE TABLE IF NOT EXISTS datas (
    id INTEGER AUTO_INCREMENT,
    usuario_id INTEGER NOT NULL,
    grupo_id INTEGER NULL,
    dia INTEGER NOT NULL,
    mes INTEGER NOT NULL,
    ano INTEGER NULL,
    descricao VARCHAR(50) NOT NULL,
    dia_morte INTEGER NOT NULL,
    mes_morte INTEGER NOT NULL,
    ano_morte INTEGER NULL,
    observacao VARCHAR(300) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
    FOREIGN KEY (grupo_id) REFERENCES grupos (id)
);
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datas extends Model {
    protected $table = 'datas';
    
    protected $fillable = [
        'id_usuarios',
        'id_calendarios',
        'dia',
        'mes',
        'ano',
        'descricao',
        'dia_morte',
        'mes_morte',
        'ano_morte',
    ];
}