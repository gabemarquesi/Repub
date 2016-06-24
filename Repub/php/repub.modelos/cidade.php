<?php

include_once 'estado.php';

class Cidade {
    public $id;
    public $nome;
    public $estado;
    
    public function __construct($id, $nome, Estado $estado) {
        $this->id = $id;
        $this->nome = $nome;
        $this->estado = $estado;
    }
    
}
