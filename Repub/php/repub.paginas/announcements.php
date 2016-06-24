<?php

include_once '../exceptionHandler.php';
include_once '../repub.controlador/anuncioControlador.php';
include_once '../repub.modelos/usuario.php';


class Annoucements {

    public function getAnuncios($usuario_id) {
        $anuncioControlador = new AnuncioControlador();
        $anuncios = $anuncioControlador->getByUsuario($usuario_id);
        if ($anuncios != null) {
            echo json_encode($anuncios);
        }
    }

    public function deleteAnuncio($anuncio_id) {
        $anuncioControlador = new AnuncioControlador();
        return $anuncioControlador->delete($anuncio_id);
    }

}

session_start();
$pagina = new Annoucements();
$acao = $_REQUEST["action"];

switch ($acao) {
    case "getAnuncios":
        $usuario_id = $_SESSION['usuario']->id;
        $pagina->getAnuncios($usuario_id);
    case "delete":
        $anuncio_id = $_REQUEST["anuncio_id"];
        $pagina->deleteAnuncio($anuncio_id);
}
