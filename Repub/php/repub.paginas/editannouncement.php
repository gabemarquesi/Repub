<?php
include_once '../exceptionHandler.php';
include_once 'createannouncement.php';
include_once '../repub.controlador/anuncioControlador.php';
include_once '../repub.controlador/cidadeControlador.php';
include_once 'resposta.php';

session_start();
if (empty($_SESSION['usuario'])) {
    session_abort();
    die();
}

$anuncioControlador = new AnuncioControlador();
$cidadeControlador = new CidadeControlador();
$anuncioExistente = $anuncioControlador->get($_REQUEST['id']);

if ($anuncioExistente->donoID != $_SESSION['usuario']->id) {
    echo "Você não tem permissão para editar este anúncio!";
    die();
}

$anuncioNovo = anuncioRequest();

$anuncioExistente->ativo = $anuncioNovo->ativo;
$anuncioExistente->bairro = $anuncioNovo->bairro;
$anuncioExistente->cidade = $cidadeControlador->get($anuncioNovo->cidade->id);
$anuncioExistente->descricao = $anuncioNovo->descricao;
$anuncioExistente->endereco = $anuncioNovo->endereco;
$anuncioExistente->garagem = $anuncioNovo->garagem;
$anuncioExistente->imagemCapa = $anuncioNovo->imagemCapa;
$anuncioExistente->imagens = $anuncioNovo->imagems;
$anuncioExistente->internet = $anuncioNovo->internet;
$anuncioExistente->nome = $anuncioNovo->nome;
$anuncioExistente->quartos = $anuncioNovo->quartos;
$anuncioExistente->telefone = $anuncioNovo->telefone;
$anuncioExistente->titulo = $anuncioNovo->titulo;
$anuncioExistente->valorMedioContas = $anuncioNovo->valorMedioContas;

try {
    if ($anuncioControlador->update($anuncioExistente) != null) {
        echo json_encode(new Resposta('Seu anúncio foi editado com sucesso!', true));
    } else {
        echo json_encode(new Resposta('Um erro ocorreu ao salvar o seu anúncio, tente novamente.', true));
    }
} catch (Exception $ex) {
    echo json_encode(new Resposta('Um erro ocorreu ao salvar o seu anúncio, tente novamente.', false));
}