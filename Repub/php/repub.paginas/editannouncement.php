<?php

class EditAnnouncement {

    public $anuncio;
    //public $imagensAnuncio = []; //verificar se é preciso salvar essa informacao
    public $quartos = [];

    public function setAnuncio($titulo, $endereco, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $estado) {
        $anuncio = new Anuncio(null, $titulo, $endereco, 1, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $estado);
        $anuncioControlador = new anuncioControlador();
        $this->anuncio = $anuncioControlador->create($anuncio);
    }

    public function setImagemAnuncio($endereco) {
        $imagem = new Imagem(null, $endereco);
        $imagemControlador = new ImagemControlador();
        $imagem = $imagemControlador->create($imagem);
        $imagemAnuncio = new Imagem_anuncio($this->anuncio->ID, $imagem->imagemID);
        $imagemAnuncioControlador = new Imagem_anuncioControlador();
        //$this->imagensAnuncio[] =  $imagemAnuncioControlador->create($imagemAnuncio);
    }

    public function setQuarto($valorQuarto, $descricaoQuarto, $alugado) {
        $quarto = new Quarto(null, $valorQuarto, $descricaoQuarto, $this->anuncio->ID, $alugado);
        $quartoControlador = new QuartoControlador();
        $this->quartos[] = $quartoControlador->create($quarto);
    }

    public function setImagemQuarto($endereco, $indexQuarto) {
        $imagem = new Imagem(null, $endereco);
        $imagemControlador = new ImagemControlador();
        $imagem = $imagemControlador->create($imagem);
        $imagemQuarto = new Imagem_quarto($this->quartos[$indexQuarto], $imagem->imagemID);
        $imagemQuartoControlador = new Imagem_quartoControlador();
        $imagemQuartoControlador->create($imagemQuarto);
    }

}

function salvarImagem($idImagem, $j) {
    $target_dir = "diretorio/do/caralho"; //adicionar diretorio
    $target_file = $target_dir . basename($_FILES[$idImagem][$j]["name"]);
    $uploadOK = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Verifica se o arquvo existe
    if (file_exists($target_file)) {
        echo "Desculpe, o arquivo já existe.";
        $uploadOk = 0;
    }
    // Verifica o tamanho do arquivo
    if ($_FILES["fileToUpload"]["size"] > 500000000) {
        echo "A imagem é muito grande, ela de ser menor que 5MB.";
        $uploadOk = 0;
    }
    // Verifica a extensão do arquivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Apenas arquivos .jpg, .png e .jpeg são aceitas";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Houve um erro ao tentar enviar a imagem!";
    } else {
        if (move_uploaded_file($_FILES[$idImagem][$j]["tmp_name"], $target_file)) {
            $pagina->setImagemQuarto($target_file, $i);
            echo "A imagem " . basename($_FILES[$idImagem][$j]["name"]) . " foi enviada.";
        } else {
            echo "Houve um erro ao tentar enviar a imagem!";
        }
    }
}

$pagina = new EditAnnouncement();

$titulo = $_REQUEST["titulo"];
$endereco = $_REQUEST["endereco"];
$nome = $_REQUEST["nome"];
$garagem = $_REQUEST["garagem"];
$descricao = $_REQUEST["descricao"];
$valorMedioContas = $_REQUEST["valorContas"];
$internet = $_REQUEST["internet"];
$bairro = $_REQUEST["bairro"];
$cidade = $_REQUEST["cidade"];
$estado = $_REQUEST["estado"];
$pagina->setAnuncio($titulo, $endereco, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $estado);

for ($i = 0; $i < 5; $i++) {
    if ($_REQUEST["anuncio-imagem"][$i] != null) {
        salvarImagem("anuncio-imagem", $i);
    }
}

for ($i = 0; $i < count($_REQUEST["quarto-valor"]); $i++) {
    $valorQuarto = $_REQUEST["quarto-valor"][$i];
    $descricaoQuarto = $_REQUEST["quarto-descricao"][$i];
    $alugado = $_REQUEST["quarto-alugado"][$i];
    $pagina->setQuarto($valorQuarto, $descricaoQuarto, $alugado);
}

//imagens dos quartos
$i = 0;
while (!empty($_FILES["quarto-$i-imagem"][0])) {
    for ($j = 0; $j < 3; $j++) {
        if (!empty($_FILES["quarto-$i-imagem"][$j])) {
            salvarImagem("quarto-$i-imagem", $j);
        }
    }
    $i++;
}
?>