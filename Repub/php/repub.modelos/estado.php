<?php

class Estado {
    public $id;
    public $nome;
    public $uf;
    public $paisID;
    
    public function __construct($id, $nome, $uf, $paisID) {
        $this->id = $id;
        $this->nome = $nome;
        $this->uf = $uf;
        $this->paisID = $paisID;
    }
    
}
