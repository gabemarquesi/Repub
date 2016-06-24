<?php

include_once '../repub.modelos/usuario.php';

class CreateAnnouncement {

    function criarCaminho($anuncioID) {
        $endereco = '../../user-content/anuncio-' . $anuncioID;
        if (!file_exists($endereco)) {
            mkdir($endereco, 0744, true);
        }
        return $endereco;
    }

    function salvarImagem($imagem, $endereco) {
        $myfile = fopen($endereco, "w") or die("Unable to open file!");
        if (fwrite($myfile, $imagem) > 0) {
            fclose($myfile);
        } else {
            throw new Exception('Imagem não salva!');
        }
    }

}

session_start();
if ($_SESSION['usuario'] == null) {
    session_abort();
    die();
}
$pagina = new CreateAnnouncement();
$anuncioControlador = new AnuncioControlador();
$imagemControlador = new ImagemControlador();
$quartoControlador = new QuartoControlador();
$telefoneControlador = new telefoneControlador();

$usuario_id = $_SESSION['usuario']->id;
$anuncio = new Anuncio();
$anuncio->titulo = $_REQUEST['titulo'];
$anuncio->nome = $_REQUEST['nome'];
$anuncio->descricao = $_REQUEST['descricao'];
$anuncio->endereco = $_REQUEST['endereco'];
$anuncio->bairro = $_REQUEST['bairro'];
$anuncio->cidade = $_REQUEST['cidade'];
$anuncio->estado = $_REQUEST['estado'];
$anuncio->garagem = $_REQUEST['garagem-true'];
$anuncio->valorMedioContas = $_REQUEST['valorContas'];
$anuncio->internet = $_REQUEST['internet'];
$imagens_anuncio[] = $_FILES['anuncio-imagem'][];

$imagens = null;

$endereco = '../../user-content/anuncio-' . $anuncioID;

$pagina->criarCaminho($endereco);

foreach ($imagens_anuncio as $img) {

    $imagem = new Imagem(NULL, $endereco);
    $imagem->id = $imagemControlador->create($imagem);
    $imagem->endereco.='/anuncio-imagem-' . $imagem->id;
    $imagem->id = $imagemControlador->update($imagem);
    $imagens[] = $imagem;
}

$anuncio->imagens = $imagens;
$anuncio->id = $anuncioControlador->create($anuncio);

$i = 0;

foreach ($imagens_anuncio as $img) {
    $pagina->salvarImagem($img, $anuncio->imagens[$i]->endereco);
    $i++;
}

$i = 0;

foreach ($_REQUEST['valor-quarto'] as $valor_quarto) {
    $quarto = new Quarto();
    $quarto->valor = $valor_quarto;
    $quarto->descricao = $_REQUEST['descricao-quarto'][$i];
    $quarto->alugado = $_REQUEST['quarto-alugado-true'][$i];
    $quarto->anuncioID = $anuncio->id;

    foreach ($_FILES['quarto-' . $i . '-imagem'] as $img) {

        $imagem = new Imagem(NULL, $endereco);
        $imagem->id = $imagemControlador->create($imagem);
        $imagem->endereco.='/quarto-imagem-' . $imagem->id;
        $imagem->id = $imagemControlador->update($imagem);
        $imagens[] = $imagem;

        $pagina->salvarImagem($img, $imagem->endereco);
    }
    $quarto->imagens = $imagens;

    $quarto->id = $quartoControlador->create($quarto);

    $anuncio->quartos[$i] = $quarto;
    $i++;
}

$i=0;

foreach ($_REQUEST['telefone'] as $tel) {
    $telefone = new Telefone();
    $telefone->anuncioID = $anuncio->id;
    $telefone->numero = $tel;
    $telefone->id = $telefoneControlador->create($telefone);
    
    $anuncio->telefone[$i]=$telefone;
}
?>