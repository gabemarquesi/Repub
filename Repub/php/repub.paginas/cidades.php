<?php

include_once '../repub.controlador/estadoControlador.php';
include_once '../repub.controlador/cidadeControlador.php';

session_start();
if (empty($_SESSION['usuario'])) {
    session_abort();
    die();
}

$acao = $_REQUEST["action"];
switch ($acao) {
    case "getEstados":
        $estadoControlador = new EstadoControlador();
        echo json_encode($estadoControlador->getAll());
        break;
    case "getCidades":
        $estadoID = $_REQUEST['estadoID'];
        $cidadeControlador = new CidadeControlador();
        echo json_encode($cidadeControlador->getByEstado($estadoID));
        break;
}

