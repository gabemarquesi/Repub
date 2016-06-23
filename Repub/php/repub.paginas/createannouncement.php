<?php

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

    function salvarImagem($idImagem, $j) {
        $target_dir = "diretorio/do/caralho"; //adicionar diretorio
        $target_file = $target_dir . basename($_FILES[$idImagem][$j]["name"]);
        $uploadOK = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Verifica se o arquvo existe
        if (file_exists($target_file)) {
            echo "Arquivo já existente!";
            $uploadOk = 0;
        }
        // Verifica o tamanho do arquivo
        if ($_FILES["fileToUpload"]["size"] > 500000000) {
            echo "Imagem muito grande! A imagem não deve ter tamanho maior do que 5MB.";
            $uploadOk = 0;
        }
        // Verifica a extensão do arquivo
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Apenas formatos .jpg, .png e .jpeg são aceitos";
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

?>