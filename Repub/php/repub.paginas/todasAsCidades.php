<?php

class ListaCidades{
    public $bd;
    function __construct(){
        $this->bd = new BDRepub();
    }
    
    function getEstados(){
        $sql = "SELECT * FROM a14017.estado";
        $this->bd->executeQuery($sql);
    }
    
    function getCidades($codigo){
        $sql = "SELECT * FROM a14017.cidade WHERE estado = :param1";
        $this->bd->executeQuery($sql, $codigo);
    }
}

$listaCidades = new ListaCidades();

$acao = $_REQUEST["action"];
switch ($acao) {
    case "getEstados":
        $listaCidades->getEstados();
        break;
    case "getCidades":
        $listaCidades->getCidades($codigo);
        break;
}

?>