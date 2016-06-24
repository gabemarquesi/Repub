<?php

include_once '../exceptionHandler.php';
include_once '../repub.modelos/usuario.php';
include_once '../repub.controlador/telefoneControlador.php';
include_once '../repub.controlador/quartoControlador.php';
include_once '../repub.controlador/imagemControlador.php';
include_once '../repub.controlador/cidadeControlador.php';
include_once '../repub.controlador/anuncioControlador.php';

class CreateAnnouncement {

    function criarCaminho($endereco) {
        if (!is_dir($endereco)) {
            mkdir($endereco, 0777, true);
        }
        return $endereco;
    }

}

session_start();

if ($_SESSION['usuario'] == null) {
    echo 'x ';
    session_abort();
    die();
}




anuncioRequest();
echo '100000 ';

function anuncioRequest() {
    $pagina = new CreateAnnouncement();

    $anuncioControlador = new AnuncioControlador();
    $imagemControlador = new ImagemControlador();
    $quartoControlador = new QuartoControlador();
    $telefoneControlador = new TelefoneControlador();
    $cidadeControlador = new CidadeControlador();


    $usuario_id = $_SESSION['usuario']->id;
    $anuncio = new Anuncio();
    $anuncio->donoID = $usuario_id;
    $anuncio->titulo = $_REQUEST['titulo'];
    $anuncio->nome = $_REQUEST['nome'];
    $anuncio->descricao = $_REQUEST['descricao'];
    $anuncio->endereco = $_REQUEST['endereco'];
    $anuncio->bairro = $_REQUEST['bairro'];

    $cidade = $cidadeControlador->get($_REQUEST['cidade']);
    $anuncio->cidade = $cidade;

    $anuncio->garagem = $_REQUEST['garagem'];
    $anuncio->valorMedioContas = $_REQUEST['valorContas'];
    $anuncio->internet = $_REQUEST['internet'];
    $imagens_anuncio[] = $_FILES['anuncio-imagem'];

    $imagens = null;

    $hash = \hash('sha256', mt_rand() . $anuncio->titulo . mt_rand());

    $endereco = '../user-content/' . $hash;

    $pagina->criarCaminho($endereco);

    //Deve salvar a imagem depois para garantir que o anuncio será criado
    for ($i = 0; $i < 5; $i++) {

        if ($imagens_anuncio[$i] == null) {
            continue;
        }
        $imagem = new Imagem(NULL, $endereco);

        try {
            $imagem = $imagemControlador->create($imagem);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Um erro ocorreu ao criar uma imagem!');
            die();
        }

        $imagem->endereco = 'user-content/'.$hash.'/anuncio-imagem-' . $imagem->id;

        try {
            $imagem = $imagemControlador->update($imagem);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Um erro ocorreu ao criar uma imagem!');
            die();
        }

        $imagens[$i] = $imagem;
    }


    $anuncio->imagens = $imagens;
    $anuncio->imagemCapa = $imagens[0];

    for ($i = 0; $i < 5; $i++) {

        if ($imagens_anuncio[$i] == null) {
            continue;
        }

        if ($imagens_anuncio['error'][$i] == UPLOAD_ERR_OK) {
            $tmp_name = $imagens_anuncio['tmp_name'][$i];
            move_uploaded_file($tmp_name, $anuncio->imagens[$i]->endereco);
        }

        $i++;
    }

    $i = 0;

    foreach ($_REQUEST['valor-quarto'] as $valor_quarto) {
        $quarto = new Quarto();
        $quarto->valor = $valor_quarto;
        $quarto->descricao = $_REQUEST['descricao-quarto'][$i];
        $quarto->alugado = $_REQUEST['quarto-alugado'][$i];

        foreach ($_FILES['quarto-' . $i . '-imagem'] as $img) {
            if ($img['error'] != UPLOAD_ERR_OK) {
                continue;
            }
            $imagem = new Imagem(NULL, $endereco);
            try {
                $imagem = $imagemControlador->create($imagem);
            } catch (Exception $ex) {
                logException($ex);
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
                die();
            }
            $imagem->endereco='user-content'.$hash.'/quarto-imagem-' . $imagem->id;
            try {
                $imagem = $imagemControlador->update($imagem);
            } catch (Exception $ex) {
                logException($ex);
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
                die();
            }
            $imagens[] = $imagem;

            $tmp_name = $img['tmp_name'];
            move_uploaded_file($tmp_name, $anuncio->imagens[$i]->endereco);
        }
        $quarto->imagens = $imagens;
        try {
            $quarto = $quartoControlador->create($quarto);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Ocorreu um erro ao criar os quartos deste anúncio!');
            die();
        }

        $anuncio->quartos[$i] = $quarto;
        $i++;
    }

    $i = 0;

    foreach ($_REQUEST['telefone'] as $tel) {
        $telefone = new Telefone();
        $telefone->numero = $tel;
        try {
            $telefone = $telefoneControlador->create($telefone);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Um erro ocorreu ao criar os telefones para este anúncio.');
            die();
        }

        $anuncio->telefone[$i] = $telefone;
    }
    echo '39';
    try {
        $anuncio = $anuncioControlador->create($anuncio);
        echo '40';
    } catch (Exception $ex) {
        logException($ex);
        echo '41';
        foreach ($anuncio->telefone as $telefone) {
            $telefoneControlador->delete($telefone->id);
            echo '41a';
        }
        foreach ($anuncio->quartos as $quarto) {
            echo '41b';

            foreach ($quarto->imagens as $imagem) {
                echo '41c';

                $imagemControlador->delete($imagem->id);
            }
            $quartoControlador->delete($quarto->id);
        }
        foreach ($anuncio->imagens as $imagem) {
            echo '41d';

            $imagemControlador->delete($imagem->id);
        }
        
        echo json_encode('Ocorreu um erro ao criar o seu anúncio.');
        die();
    }
}

?>