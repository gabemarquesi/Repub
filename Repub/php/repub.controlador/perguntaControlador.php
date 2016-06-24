<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/pergunta.php';

class PerguntaControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.perguntas WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $pergunta = null;

        if (count($obj) > 0) {
            $pergunta = new Pergunta($obj[0]->id, $obj[0]->data, $obj[0]->pergunta, $obj[0]->resposta, $obj[0]->usuarioID);
        }

        return $pergunta;
    }

    public function create($pergunta) {
        if ($pergunta == null) {
            throw new Exception('Uma pergunta não-nula deve ser fornecida.');
        }

        $ex = Pergunta::validate($pergunta);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.perguntas (id, data, pergunta, resposta, usuarioID)
				VALUES (:param1, :param2, :param3, :param4, :param5)";
        $params = array($pergunta->id, $pergunta->data, $pergunta->pergunta, $pergunta->resposta, $pergunta->usuarioID);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu ao criar a pergunta');
        }

        $novaPergunta = $this->get($this->bd->lastID);
        return $novaPergunta;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.perguntas WHERE id = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu ao deletar a pergunta.');
        }
    }

    public function update($pergunta) {
        if ($pergunta == null) {
            throw new Exception('Uma pergunta não-nula deve ser fornecida.');
        }

        $ex = Pergunta::validate($pergunta);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "UPDATE a14017.perguntas SET data = :param1, 
            pergunta = :param2, resposta = :param3, usuarioID = :param4 
            WHERE id = :param5";
        $params = array($pergunta->data, $pergunta->pergunta, $pergunta->resposta,
            $pergunta->usuarioID, $pergunta->id);
        
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Um erro ocorreu ao atualizar a pergunta.');
        }
        
        $novaPergunta = $this->get($pergunta->id);
        
        return $novaPergunta;
    }

}

?>