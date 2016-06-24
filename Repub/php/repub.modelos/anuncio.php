<?php

Class Anuncio {

    public $id;
    public $titulo;
    public $endereco;
    public $ativo;
    public $nome;
    public $garagem;
    public $descricao;
    public $valorMedioContas;
    public $internet;
    public $bairro;
    public $cidade;
    public $donoID;
    public $imagemCapa;
    public $imagens;
    public $quartos;
    public $perguntas;
    public $telefone;

    function __construct($ID, $titulo, $endereco, $ativo, $nome, $garagem, $descricao, $valorMedioContas, $internet, $bairro, $cidade, $donoID, $imagemCapa, $imagens, $quartos, $perguntas,$telefone) {
        $this->id = $ID;
        $this->titulo = $titulo;
        $this->endereco = $endereco;
        $this->ativo = $ativo;
        $this->nome = $nome;
        $this->garagem = $garagem;
        $this->descricao = $descricao;
        $this->valorMedioContas = $valorMedioContas;
        $this->internet = $internet;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->donoID = $donoID;
        $this->imagemCapa = $imagemCapa;
        $this->imagens = $imagens;
        $this->quartos = $quartos;
        $this->perguntas=$perguntas;
                $this->telefone=$telefone;

    }

    public static function validate($anuncio) {
        if ($anuncio == null) {
             throw new Exception('Um anúncio não-nulo precisa ser fornecido.');
        }
        
        if ($anuncio->titulo == null || strlen($anuncio->titulo) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        if (strlen($anuncio->nome) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        if ( $anuncio->endereco == null || strlen($anuncio->endereco) > 100) {
            return new Exception('Overflow de caracteres!');
        }
        if ($anuncio->garagem === null) {
            return new Exception('Garagem não pode ser nulo!');
        }
        if (strlen($anuncio->descricao) > 4096) {
            return new Exception('Overflow de caracteres!');
        }
        if ($anuncio->internet > 65535) {
            return new Exception('Internet overflow!');
        }
        if ($anuncio->bairro == null || strlen($anuncio->bairro) > 45) {
            return new Exception('Overflow de caracteres!');
        }
        if ($anuncio->cidade == null) {
            return new Exception('Cidade não pode ser nulo!');
        }

        if ($anuncio->donoID == null) {
            return new Exception('Dono não pode ser nulo!');
        }

        if ($anuncio->imagemCapa == null) {
            return new Exception('Imagem de capa não pode ser nulo!');
        }

        if (count($anuncio->imagens) == 0) {
            return new Exception('O anúncio precisa ter pelo menos uma imagem!');
        }

        if (count($anuncio->quartos) == 0) {
            return new Exception('O anúncio precisa ter pelo menos um quarto!');
        }
        
        foreach ($anuncio->telefone as $telefone){
            $ex = $telefone->validate();
            if($ex!=null){
                throw  $ex;
            }
        }
        
        foreach ($anuncio->imagens as $imagem) {
            $ex = $imagem->validate();
            if ($ex != null) {
                throw $ex;
            }
        }
        
        foreach ($anuncio->quartos as $quarto) {
            $ex = $quarto->validate();
            if ($ex != null) {
                throw $ex;
            }
        }
        
        foreach ($anuncio->perguntas as $pergunta) {
            $ex = $pergunta->validate();
            if ($ex != null) {
                throw $ex;
            }
        }
        
        return null;
    }
}

?>