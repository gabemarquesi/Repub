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

}

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

//adicionando os telefones
for ($i = 0; $i < count($_REQUEST["telefone"]); $i++) {
    $telefone = new Telefone($this->anuncio->ID, $_REQUEST["telefone"][$i]);
    $telefoneControlador = new telefoneControlador();
    $telefoneControlador->create($telefone);
}

session_start();
if ($_SESSION['usuario'] == null) {
    session_abort();
}
$pagina = new CreateAnnouncement();

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


$pagina->createAnnouncement();

$imagemControlador = new ImagemControlador();
$imagens = null;

$endereco = '../../user-content/anuncio-' . $anuncioID;

$pagina->criarCaminho($endereco);

foreach ($imagens_anuncio as $img) {

    $imagem = new Imagem(NULL, $endereco);
    $imagem->id = $imagemControlador->create($imagem);
    $imagem->endereco.='/anuncio-imagem-' . $imagem->id;
    $imagem->id = $imagemControlador->update($imagem);
    $imagens[] = $imagem;

    $pagina->salvarImagem($img, $imagem->endereco);
}

$anuncioControlador = new AnuncioControlador();
$anuncio->imagens = $imagens;
$anuncio->id = $anuncioControlador->create($anuncio);

$i = 0;

foreach ($_REQUEST['valor-quarto'] as $valor_quarto) {
    $quarto = new Quarto();
    $quarto->valor = $valor_quarto;
    $quarto->descricao = $_REQUEST['descricao-quarto'][$i];
    $quarto->alugado = $_REQUEST['quarto-alugado-true'][$i];
    $quarto->anuncioID=$anuncio->id;

    foreach ($_FILES['quarto-' . $i . '-imagem'] as $img) {

        $imagem = new Imagem(NULL, $endereco);
        $imagem->id = $imagemControlador->create($imagem);
        $imagem->endereco.='/quarto-imagem-' . $imagem->id;
        $imagem->id = $imagemControlador->update($imagem);
        $imagens[] = $imagem;

        $pagina->salvarImagem($img, $imagem->endereco);
    }
    $quarto->imagens = $imagens;
    $anuncio->quartos[$i] = $quarto;
    $i++;
}

?>