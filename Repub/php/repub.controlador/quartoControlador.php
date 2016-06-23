<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/quarto.php';

class QuartoControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.quartos WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $quarto = null;

        if (count($obj) > 0) {
            $quarto = new Quarto($obj[0]->id, $obj[0]->valor, $obj[0]->descricao, $obj[0]->anuncioID, $obj[0]->alugado);
        }

        return $quarto;
    }

    public function create($quarto) {
        if ($quarto == null) {
            throw new Exception('Um quarto não-nulo deve ser fornecido.');
        }

        $ex = Quarto::validate($quarto);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.quartos (valor, descricao, anuncioID, alugado) " .
                "VALUES (:param1, :param2, :param3, :param4)";
        $params = array($quarto->valor, $quarto->descricao, $quarto->anuncioID, $quarto->alugado);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu ao criar o quarto.');
        }

        $novoQuarto = $this->get($this->bd->lastID);

        return $novoQuarto;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.quartos WHERE id = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro ao deletar o quarto.');
        }
    }

    public function update($quarto) {
        if ($quarto == null) {
            throw new Exception('Um quarto não-nulo deve ser fornecido.');
        }

        $ex = Quarto::validate($quarto);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "UPDATE a14017.quarto SET 
                    valor = :param1,
                    descricao = :param2, 
                    anuncioID = :param3,
                    alugado = :param4 
                 WHERE
                    id = :param5";
        $params = array($quarto->valor, $quarto->descricao, $quarto->anuncioID, $quarto->alugado, $quarto->id);
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Ocorreu um erro ao atualizar o quarto.');
        }
        
        $novoQuarto = $this->get($quarto->id);
        
        return $novoQuarto;
    }

}