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
        echo '1';
 
        if (is_dir($endereco)) {
            echo '3';
            mkdir($endereco, 0777, true);
        }
        echo '4';
        return $endereco;
    }

    function salvarImagem($imagem, $endereco) {
        
        $myfile = fopen($endereco, "wb"); // or die("Unable to open file!");
        
        if (fwrite($myfile, $imagem) !== false) {            
            fclose($myfile);
        } else {
            logException($ex);
            echo error_get_last();
            throw new Exception('Imagem não salva!');
            die();
        }
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
 
    $hash =\hash('sha256', mt_rand() . $anuncio->titulo . mt_rand());
    
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

        $imagem->endereco = '/anuncio-imagem-' . $imagem->id;

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
        echo'22';
        $pagina->salvarImagem($imagens_anuncio[$i], $anuncio->imagens[$i]->endereco);
        echo '22a';
        $i++;
    }
        echo'23';

    $i = 0;

    foreach ($_REQUEST['valor-quarto'] as $valor_quarto) {
        echo'24';
        $quarto = new Quarto();
        $quarto->valor = $valor_quarto;
        $quarto->descricao = $_REQUEST['descricao-quarto'][$i];
        $quarto->alugado = $_REQUEST['quarto-alugado'][$i];
echo'25';
        foreach ($_FILES['quarto-' . $i . '-imagem'] as $img) {
echo'26';
            $imagem = new Imagem(NULL, $endereco);
            try {
                $imagem = $imagemControlador->create($imagem);
            } catch (Exception $ex) {
                logException($ex);
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
                die();
            }
            echo'28';
            $imagem->endereco.='/quarto-imagem-' . $imagem->id;
            echo'29';
            try {
                $imagem = $imagemControlador->update($imagem);
            } catch (Exception $ex) {
                logException($ex);
                echo json_encode('Um erro ocorreu ao criar uma imagem!');
                die();
            }
            echo'30';
            $imagens[] = $imagem;
            $pagina->salvarImagem($img, $imagem->endereco);
            echo '31';
        }
        $quarto->imagens = $imagens;
echo '32';
        try {
            $quarto = $quartoControlador->create($quarto);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Ocorreu um erro ao criar os quartos deste anúncio!');
            die();
        }
        echo '33';

        $anuncio->quartos[$i] = $quarto;
        $i++;
        echo '34';
    }

    $i = 0;

    echo '35';
    foreach ($_REQUEST['telefone'] as $tel) {
        $telefone = new Telefone();
        $telefone->numero = $tel;
        echo '36';
        try {
            $telefone = $telefoneControlador->create($telefone);
        } catch (Exception $ex) {
            logException($ex);
            echo json_encode('Um erro ocorreu ao criar os telefones para este anúncio.');
            die();
        }
        echo '38';

        $anuncio->telefone[$i] = $telefone;
    }
echo '39';
    try {
        $anuncio = $anuncioControlador->create($anuncio);
    } catch (Exception $ex) {
        foreach ($anuncio->telefone as $telefone) {
            $telefoneControlador->delete($telefone->id);
        }
        foreach ($anuncio->quartos as $quarto){
            foreach ($quarto->imagens as $imagem){
                $imagemControlador->delete($imagem->id);
            }
            $quartoControlador->delete($quarto->id);   
        }
        foreach ($anuncio->imagens as $imagem){
            $imagemControlador->delete($imagem->id);
        }
        logException($ex);
        echo json_encode('Ocorreu um erro ao criar o seu anúncio.');
        die();
    }
}

?>