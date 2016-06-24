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

function anuncioRequest() {

    $anuncioControlador = new AnuncioControlador();
    $imagemControlador = new ImagemControlador();
    $quartoControlador = new QuartoControlador();
    $telefoneControlador = new telefoneControlador();
    $cidadeControlador = new CidadeControlador();


    $usuario_id = $_SESSION['usuario']->id;
    $anuncio = new Anuncio();
    $anuncio->titulo = $_REQUEST['titulo'];
    $anuncio->nome = $_REQUEST['nome'];
    $anuncio->descricao = $_REQUEST['descricao'];
    $anuncio->endereco = $_REQUEST['endereco'];
    $anuncio->bairro = $_REQUEST['bairro'];

    $cidade = $cidadeControlador->get($_REQUEST['cidade']);
    $anuncio->cidade = $cidade;

    $anuncio->garagem = $_REQUEST['garagem-true'];
    $anuncio->valorMedioContas = $_REQUEST['valorContas'];
    $anuncio->internet = $_REQUEST['internet'];
    $imagens_anuncio[] = $_FILES['anuncio-imagem'][];

    $imagens = null;

    $endereco = '../../user-content/anuncio-' . $anuncioID;

    $pagina->criarCaminho($endereco);


    for ($i = 0; $i < 5; $i++) {
        if ($imagens_anuncio[$i] == null) {
            continue;
        }
        $imagem = new Imagem(NULL, $endereco);
        try {
            $imagem = $imagemControlador->create($imagem);
        } catch (Exception $ex) {
            echo json_encode('Um erro ocorreu ao criar uma imagem!');
        }
        $imagem->endereco.='/anuncio-imagem-' . $imagem->id;
        try {
            $imagem = $imagemControlador->update($imagem);
        } catch (Exception $ex) {
            echo json_encode('Um erro ocorreu ao criar uma imagem!');
        }
        $imagens[$i] = $imagem;
    }

    $anuncio->imagens = $imagens;
    $anuncio->imagemCapa = $imagens[0];
    Try {
        $anuncio->id = $anuncioControlador->create($anuncio);
    } catch (Exception $ex) {
        echo json_encode('Ocorreu um erro ao criar o seu anúncio.')
    }

    $i = 0;

    for ($i = 0; $i < 5; $i++) {
        if ($imagens_anuncio[$i] == null) {
            continue;
        }
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
            try {
                $imagem = $imagemControlador->create($imagem);
            } catch (Exception $ex) {
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
            }
            $imagem->endereco.='/quarto-imagem-' . $imagem->id;
            try {
                $imagem = $imagemControlador->update($imagem);
            } catch (Exception $ex) {
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
            }
            $imagens[] = $imagem;

            $pagina->salvarImagem($img, $imagem->endereco);
        }
        $quarto->imagens = $imagens;

        try {
            $quarto = $quartoControlador->create($quarto);
        } catch (Exception $ex) {
            echo json_encode('Ocorreu um erro ao criar os quartos deste anúncio!')
        }

        $anuncio->quartos[$i] = $quarto;
        $i++;
    }

    $i = 0;

    foreach ($_REQUEST['telefone'] as $tel) {
        $telefone = new Telefone();
        $telefone->anuncioID = $anuncio->id;
        $telefone->numero = $tel;
        try {
            $telefone = $telefoneControlador->create($telefone);
        } catch (Exception $ex) {
            echo json_encode('Um erro ocorreu ao criar os telefones para este anúncio.');
        }

        $anuncio->telefone[$i] = $telefone;
    }
}

?>