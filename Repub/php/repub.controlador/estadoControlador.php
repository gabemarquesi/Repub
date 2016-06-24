<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/estado.php';

class EstadoControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.estado WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $estado = null;

        if (count($obj) > 0) {
            $estado = new Estado($obj[0]->id, $obj[0]->nome, $obj[0]->uf, $obj[0]->paisID);
        }
        
        return $estado;
    }

    public function getAll() {
        $sql = "SELECT id FROM a14017.estado";
        $estados = null;
        foreach ($this->bd->executeQuery($sql, null) as $obj) {
            $estados[] = $this->get($obj->id);
        }

        return $estados;
    }

}
