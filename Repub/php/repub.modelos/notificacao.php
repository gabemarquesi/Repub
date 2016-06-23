<?php

class Notificacao {

    public $id;
    public $texto;
    public $usuarioID;

    function __construct($id, $texto, $usuarioID) {
        $this->id = $id;
        $this->texto = $texto;
        $this->usuarioID = $usuarioID;
    }

    public static function validate($notificacao) {
        if ($notificacao == null) {
            throw new Exception('Uma notificação não-nula precisa ser fornecida.');
        }

        if (strlen($notificacao->texto == null || $notificacao->texto) > 500) {
            return new Exception('Overflow de caracteres!');
        }
        if (strlen($notificacao->usuarioID) > 11) {
            return new Exception('Overflow de caracteres!');
        }

        return null;
    }

}

?>
