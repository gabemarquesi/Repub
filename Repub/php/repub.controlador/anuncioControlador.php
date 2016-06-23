<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.controlador/imagemControlador.php';
include_once '../repub.modelos/anuncio.php';
include_once '../repub.modelos/imagem.php';
include_once '../repub.modelos/quarto.php';

class AnuncioControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($ID) {
        $sql = "SELECT * FROM a14017.anuncios WHERE id = :param1";
        $params[] = $ID;
        $obj = $this->bd->executeQuery($sql, $params);
        $anuncio = null;

        if (count($obj) > 0) {
            $anuncio = new Anuncio($obj[0]->id, $obj[0]->titulo, $obj[0]->endereco, $obj[0]->ativo, $obj[0]->nome, $obj[0]->garagem, $obj[0]->descricao, $obj[0]->valorMedioContas, $obj[0]->internet, $obj[0]->bairro, $obj[0]->cidadeID, $obj[0]->donoID);
        }

        $imagemControlador = new ImagemControlador();
        $anuncio->imagemCapa = $imagemControlador->get($obj[0]->imagemcapa);

        $sql = "SELECT imagemID FROM imagens_anuncio WHERE anuncioID = :param1";
        $params = array($ID);

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $imagem = $imagemControlador->get($result->imagemID);
            if ($imagem != null) {
                $anuncio->imagens[] = $imagem;
            }
        }

        return $anuncio;
    }

    public function getByUsuario($usuarioID) {
        $sql = "SELECT id FROM a14017.anuncios WHERE donoID = :param1";
        $params[] = $usuarioID;
        $anuncios = null;

        foreach ($this->bd->executeQuery($sql, $params) as $result) {
            $anuncios[] = $this->get($result->id);
        }

        return $anuncios;
    }

    public function create($anuncio) {
        if ($anuncio == null) {
            throw new Exception('Um anúncio não-nulo precisa ser fornecido!');
        }

        $ex = Anuncio::validate($anuncio);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.anuncios (titulo, endereco, ativo, nome,
                    garagem, descricao, valorMedioContas, internet, bairro, cidadeID, donoID, imagemCapa)
                    VALUES (:param1, :param2, :param3, :param4, :param5, 
                    :param6, :param7, :param8, :param9, ':param10, :param11, :param12);";

        $params = array($anuncio->titulo, $anuncio->endereco, $anuncio->ativo,
            $anuncio->nome, $anuncio->garagem, $anuncio->descricao,
            $anuncio->valorMedioContas, $anuncio->internet,
            $anuncio->bairro, $anuncio->cidadeID, $anuncio->donoID, $anuncio->imagemCapa->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o create.');
        }

        $anuncioCriado = $this->get($this->bd->lastID);

        foreach ($anuncio->imagens as $imagem) {
            $sql = "INSERT INTO a14017.imagens_anuncios (imagemID, anuncioID) VALUES (:param1, :param2)";
            $params = array($imagem->id, $anuncioCriado->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o create.');
            }
        }

        return $anuncioCriado;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.anuncios WHERE id = :param1";
        $params = array($id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o delete.');
        }
    }

    public function update(Anuncio $anuncio) {
        if ($anuncio == null) {
            throw new Exception('Um anúncio não-nulo precisa ser fornecido!');
        }

        $ex = Anuncio::validate($anuncio);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "UPDATE a14017.anuncios 
                    SET titulo=:param1, endereco=:param2, ativo=:param3, nome=:param4,;
                        garagem=:param5, descricao=:param6,
                        valormediocontas=:param7, internet=:param8,
                        bairro=:param9, cidadeID=:param10, donoID=:param11,
                        imagemcapa = :param12
                    WHERE id = :param13";

        $params = array($anuncio->titulo, $anuncio->endereco, $anuncio->ativo, $anuncio->nome,
            $anuncio->garagem, $anuncio->descricao, $anuncio->valorMedioContas, $anuncio->internet,
            $anuncio->bairro, $anuncio->cidade, $anuncio->donoID, $anuncio->imagemCapa, $anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        $sql = "DELETE FROM a14017.imagens_anuncio WHERE anuncioID = :param1";
        $params = array($anuncio->id);

        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        foreach ($anuncio->imagens as $imagem) {
            $sql = "INSERT INTO a14017.imagens_anuncios (imagemID, anuncioID) VALUES (:param1, :param2)";
            $params = array($imagem->id, $anuncio->id);

            if (!$this->bd->executeNonQuery($sql, $params)) {
                throw new Exception('Ocorreu um erro durante o update.');
            }
        }

        $novoAnuncio = $this->get($anuncio->id);

        return $novoAnuncio;
    }

}

?>