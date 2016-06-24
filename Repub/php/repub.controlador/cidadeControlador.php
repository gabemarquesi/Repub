<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.controlador/estadoControlador.php';
include_once '../repub.modelos/cidade.php';

class CidadeControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.cidade WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $cidade = null;

        if (count($obj) > 0) {
            $cidade = new Cidade($obj[0]->id, $obj[0]->nome);
        }

        $estadoControlador = new EstadoControlador();
        $cidade->estado = $estadoControlador->get($obj[0]->estadoID);
        
        return $cidade;
    }

    public function getByEstado($estadoID) {
        $sql = "SELECT id FROM a14017.cidade WHERE estadoID = :param1";
        $params = array($estadoID);
        $cidades = null;
        
        foreach($this->bd->executeQuery($sql, $params) as $obj){
            $cidades[] = $this->get($obj->id);
        }     
        
        return $cidades;
    }
    
}
