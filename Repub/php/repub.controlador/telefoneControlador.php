<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/telefone.php';

class TelefoneControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.telefones WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $telefone = null;

        if (count($obj) > 0) {
            $telefone = new Telefone($obj[0]->id, $obj[0]->numero);
        }

        return $telefone;
    }

    public function create($telefone) {
        if ($telefone == null) {
            throw new Exception('Um telefone não-nulo deve ser fornecido.');
        }

        $ex = Telefone::validate($telefone);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.telefones (numero)
                    VALUES (:param1)";
        $params = array( $telefone->numero);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro ao criar o telefone.');
        }

        $novoTelefone = $this->get($this->bd->lastID);

        return $novoTelefone;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.telefones WHERE id = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Ocorreu um erro ao deletar o telefone.');
        }
    }

    public function update($telefone) {
        if ($telefone == null) {
            throw new Exception('Um telefone não-nulo deve ser fornecido.');
        }

        $ex = Telefone::validate($telefone);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "UPDATE INTO a14017.telefones 
                    SET numero=:param1
                    WHERE id = :param2";
        $params = array($telefone->numero, $telefone->id);
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Ocorreu um erro ao atualizar o telefone.');
        }
        
        $novoTelefone = $this->get($telefone->id);
        
        return $novoTelefone;
    }

}
