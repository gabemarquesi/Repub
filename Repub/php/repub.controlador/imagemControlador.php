<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/imagem.php';

class ImagemControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.imagens WHERE ID = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $imagem = null;

        if (count($obj) > 0) {
            $imagem = new Imagem($obj[0]->id, $obj[0]->endereco);
        }

        return $imagem;
    }

    public function create($imagem) {
        if ($imagem == null) {
            throw new Exception('Uma imagem não-nula precisa ser fornecida.');
        }

        $ex = Imagem::validate($imagem);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.imagens (imagemID, endereco)
				VALUES (:param1, :param2)";

        $params = array($imagem->id, $imagem->endereco);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu durante a criação.');
        }

        $novaImagem = $this->get($this->bd->lastID);

        return $novaImagem;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.imagens WHERE id = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o delete.');
        }
    }

    public function update($imagem) {
        if ($imagem == null) {
            throw new Exception('Uma imagem não-nula precisa ser fornecida.');
        }

        $ex = Imagem::validate($imagem);
        if ($ex != null) {
            throw $ex;
        }
        
        $sql = "UPDATE a14017.imagens SET endereco = :param1 WHERE id = :param2";
        $params = array($imagem->imagemID, $imagem->endereco);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro durante o update.');
        }

        $novaImagem = $this->get($imagem->id);
        return $novaImagem;
    }

}
