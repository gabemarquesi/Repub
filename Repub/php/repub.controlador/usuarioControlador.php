<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/usuario.php';

class UsuarioControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function getByID($id) {
        $sql = "SELECT * FROM a14017.usuarios WHERE id = :param1";
        $params = array($id);
        $obj = $this->bd->executeQuery($sql, $params);
        $usuario = null;

        if (count($obj) > 0) {
            $usuario = new Usuario($obj[0]->id, $obj[0]->nome, $obj[0]->senha, $obj[0]->email, $obj[0]->cidadeID);
        }

        return $usuario;
    }

    public function getByEmail($email) {
        $sql = "SELECT id FROM a14017.usuarios WHERE email = :param1";
        $params = array($email);
        $obj = $this->bd->executeQuery($sql, $params);

        if (count($obj) > 0){
            return $this->getByID($obj[0]->id);
        }
        
        return null;
    }

    public function create($usuario) {
        if ($usuario == null){
            throw new Exception('Um usuário não-nulo precisa ser fornecido.');
        }
        
        $ex = Usuario::validate($usuario);
        if ($ex != null){
            throw $ex;
        }
        
        $sql = "INSERT INTO a14017.usuarios (nome, senha, email, cidadeID)
                    VALUES (:param1,:param2,:param3,:param4)";
        
        $params = array($usuario->nome, \hash("sha256", $usuario->senha . 'no-rainbow'), $usuario->email, $usuario->cidadeID);
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Ocorreu um erro ao criar o usuário');
        }
        
        $novoUsuario = $this->getByID($this->bd->lastID);
        return $novoUsuario;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.usuarios WHERE ID = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Ocorreu um erro ao deletar o usuário');
        }
    }

    public function update($usuario) {
        if ($usuario == null){
            throw new Exception('Um usuário não-nulo precisa ser fornecido.');
        }
        
        $ex = Usuario::validate($usuario);
        if ($ex != null){
            throw $ex;
        }
        
        $sql = "UPDATE INTO a14017.usuarios 
                    SET nome=:param1
                        senha=:param2, 
                        email=:param3,
                        cidadeID=:param4 
                    WHERE ID = :param5";
        $params = array($usuario->nome, $usuario->senha, $usuario->email, $usuario->cidadeID, $usuario->id);
        if (!$this->bd->executeNonQuery($sql, $params)){
            throw new Exception('Ocorreu um erro ao atualizar o usuário');
        }
        
        $novoUsuario = $this->getByID($usuario->id);
        
        return $novoUsuario;
    }

}

?>