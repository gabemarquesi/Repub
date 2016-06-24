<?php

include_once 'createannouncement.php';
include_once '../repub.controlador/anuncioControlador.php';

class EditAnnouncement {
    
}

session_start();
if (empty($_SESSION['usuario'])) {
    session_abort();
    die();
}

$anuncioControlador = new AnuncioControlador();
$anuncioExistente = $anuncioControlador->get($ID)