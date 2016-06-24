<?php

include_once '../repub.modelos/usuario.php';

class CreateAnnouncement {

    public $anuncio;
    public $quartos = [];

    function criarAnuncio($titulo, $endereco, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $estado) {
        $anuncio = new Anuncio($titulo, $endereco, 1, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $estado);
        $controller = new anuncioControlador();
        $this->anuncio = $controller->create($anuncio);
        echo json_encode(true);
    }

    function setQuarto($valorQuarto, $descricaoQuarto, $alugado) {
        $quarto = new Quarto(null, $valorQuarto, $descricaoQuarto, $this->anuncio->ID, $alugado);
        $quartoControlador = new QuartoControlador();
        $this->quartos[] = $quartoControlador->create($quarto);
    }

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

    public function setImagemQuarto($endereco, $indexQuarto) {
        $imagem = new Imagem(null, $endereco);
        $imagemControlador = new ImagemControlador();
        $imagem = $imagemControlador->create($imagem);
        $imagemQuarto = new Imagem_quarto($this->quartos[$indexQuarto]->ID, $imagem->imagemID);
        $imagemQuartoControlador = new Imagem_quartoControlador();
        $imagemQuartoControlador->create($imagemQuarto);
    }

}

$page = new CreateAnnouncement();
$page->criarAnuncio($_REQUEST["titulo"], $_REQUEST["endereco"], $_REQUEST["nome"], $_REQUEST["garagem"], $_REQUEST["descricao"], $_REQUEST["valorContas"], $_REQUEST["internet"], $_REQUEST["bairro"], $_REQUEST["cidade"], $_REQUEST["estado"]);

for ($i = 0; $i < 5; $i++) {
    if ($_REQUEST["anuncio-imagem"][$i] != null) {
        salvarImagem("anuncio-imagem", $i);
    }
}

for ($i = 0; $i < count($_REQUEST["quarto-valor"]); $i++) {
    $valor = $_REQUEST["quarto-valor"][$i];
    $descricao = $_REQUEST["quarto-descricao"][$i];
    $alugado = $_REQUEST["quarto-alugado"][$i];
    $pagina->setQuarto($valor, $descricao, $alugado);
}

$i = 0;
while (!empty($_FILES["quarto-$i-imagem"][0])) {
    for ($j = 0; $j < 3; $j++) {
        if (!empty($_FILES["quarto-$i-imagem"][$j])) {
            salvarImagem("quarto-$i-imagem", $j);
        }
    }
    $i++;
}

//adicionando os telefones
for ($i = 0; $i < count($_REQUEST["telefone"]); $i++) {
    $telefone = new Telefone($this->anuncio->ID, $_REQUEST["telefone"][$i]);
    $telefoneControlador = new telefoneControlador();
    $telefoneControlador->create($telefone);
}

session_start();
$pagina = new CreateAnnouncement();

$usuario_id = $_SESSION['usuario']->id;
$titulo_anuncio = $_REQUEST['titulo'];
$nome_anuncio = $_REQUEST['nome'];
$telefone_anuncio[] = $_REQUEST['telefone'][];
$descricao_anuncio = $_REQUEST['descricao'];
$endereco_anuncio = $_REQUEST['endereco'];
$bairro_anuncio = $_REQUEST['bairro'];
$cidade_anuncio = $_REQUEST['cidade'];
$estado_anuncio = $_REQUEST['estado'];
$garagem_anuncio = $_REQUEST['garagem-true'];
$valorMedioContas_anuncio = $_REQUEST['valorContas'];
$internet_anuncio = $_REQUEST['internet'];
$imagens_anuncio[] = $_FILES['anuncio-imagem'][];
$i = 0;

foreach ($_REQUEST['valor-quarto'] as $valor_quarto) {

    $valorQuarto_anuncio[$i] = $valor_quarto;
    $descricaoQuarto_anuncio[$i] = $_REQUEST['descricao-quarto'][$i];
    $alugado_anuncio[$i] = $_REQUEST['quarto-alugado-true'][$i];
    foreach ($_FILES['quarto-' . $i . '-imagem'] as $imagem) {
        $imagemQuarto_anuncio[$i][] = $imagem;
    }

    $i++;
}

$pagina->createAnnouncement();

$imagemControlador = new ImagemControlador();
$imagens = null;
$endereco = '../../user-content/anuncio-' . $anuncioID;

foreach ($imagens_anuncio as $img) {
     
    $imagem = new Imagem(NULL, $endereco);
    $imagem->id = $imagemControlador->create($imagem);
    $imagem->endereco.='/anuncio-imagem-'.$imagem->id;
    $imagem->id = $imagemControlador->update($imagem);
    $imagens[] = $imagem->id;
}

$anuncioControlador = new AnuncioControlador();
$anuncio = new Anuncio(null, $titulo_anuncio, $endereco_anuncio, null, $nome_anuncio, $garagem_anuncio, $descricao_anuncio, $valorMedioContas_anuncio, $internet_anuncio, $bairro_anuncio, $cidade_anuncio, $usuario_id, null, $imagens);
$anuncio->id=$anuncioControlador->create($anuncio);

$pagina->criarCaminho($endereco);

foreach ($imagens_anuncio as $img) {
    salvarImagem($idImagem, $j);
    $imagem = new Imagem();
    $imagens[] = $imagemControlador->create($img);
}


$imagensQuarto = $imagemControlador->create($imagens_anuncio);
?>