<?php

include_once '../repub.persistencia/bd_repub.php';
include_once '../repub.modelos/notificacao.php';

class NotificacaoControlador {

    public $bd;

    function __construct() {
        $this->bd = new BDRepub();
    }

    public function get($id) {
        $sql = "SELECT * FROM a14017.notificacao WHERE id=:param1";
        $params[] = $id;
        $obj = $this->bd->executeQuery($sql, $params);

        if (count($obj) > 0) {
            $notificacao = new Notificacao($obj[0]->id, $obj[0]->texto, $obj[0]->usuarioID);
        }
        return $notificacao;
    }

    public function create($notificacao) {
        if ($notificacao == null) {
            throw new Exception('Uma notificação não-nula precisa ser fornecida.');
        }

        $ex = Notificacao::validate($notificacao);
        if ($ex != null) {
            throw $ex;
        }

        $sql = "INSERT INTO a14017.notificacao (usuarioID, texto) VALUES (:param1, :param2)";
        $params = array($notificacao->usuarioID, $notificacao->texto);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu durante a criação da notificação.');
        }

        $novaNotificacao = $this->get($this->bd->lastID);

        return $novaNotificacao;
    }

    public function delete($id) {
        $sql = "DELETE FROM a14017.notificacao WHERE id = :param1";
        $params = array($id);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu ao deletar a notificação.');
        }
    }

    public function update($notificacao) {
        if ($notificacao == null) {
            throw new Exception('Uma notificação não-nula precisa ser fornecida.');
        }

        $ex = Notificacao::validate($notificacao);
        if ($ex != null) {
            throw $ex;
        }
        
        $sql = "UPDATE a14017.notificacao SET usuarioID = :param1, texto = :param2";
        $params = array($notificacao->usuarioID, $notificacao->texto);
        if (!$this->bd->executeNonQuery($sql, $params)) {
            throw new Exception('Um erro ocorreu ao atualizar a notificação.');
        }

        $novaNotificacao = $this->get($notificacao->id);

        return $novaNotificacao;
    }

}
